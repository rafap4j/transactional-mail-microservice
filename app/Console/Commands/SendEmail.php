<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail as SendEmailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an e-mail message through the CLI.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $to = $this->ask('To whom this e-mail message will be sent?');
        $subject = $this->ask('What is the e-mail subject?');
        $body = $this->ask('What is the e-mail message?');

        $data = compact('to', 'subject', 'body');
        $rules = [
            'to' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required',
        ];
        $messages = [
            'to.required' => "The e-mail's recipient is required.",
            'subject.required' => "The e-mail's subject is required.",
            'subject.max' => "The e-mail's subject must not be greater than 255 characters.",
            'body.required' => "The e-mail's body is required.",
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $this->info('E-mail message not sent. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return -1;
        }

        SendEmailJob::dispatch($data);

        $this->info('The e-mail message has been enqueued and will be sent soon.');
        return 0;
    }
}
