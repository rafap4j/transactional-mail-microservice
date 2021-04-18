<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Throwable;

/**
 * Queued e-mail sending job.
 *
 * @package App\Jobs
 */
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Max attempt count.
     *
     * @var int
     */
    public $maxAttemptCount = 5;

    /**
     * E-mail service instance.
     *
     * @var \App\Services\Interfaces\EmailHandler
     */
    protected $emailService;

    /**
     * E-mail data.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->emailService = app(config('mail.service'));
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->emailService->send($this->data);
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Here, we will get another e-mail service in
        // order to try to handle the job again.
        $fallback = Arr::random(config('mail.fallback_email_services'));
        config(['mail.default_email_service' => $fallback]);

        self::dispatch($this->data);
    }
}
