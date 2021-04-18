<?php

namespace App\Services;

use App\Models\SentEmail;
use App\Services\Interfaces\EmailHandler;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SendGrid as SendGridClient;
use SendGrid\Mail\Mail;

/**
 * Sendgrid e-mail handler class.
 *
 * @package App\Services
 */
class SendgridEmailHandler implements EmailHandler
{
    /**
     * Sendgrid API key.
     *
     * @var string
     */
    private $sendgridApiKey;

    /**
     * Class constructor.
     *
     * @param  string  $sendgridApiKey
     */
    public function __construct(string $sendgridApiKey)
    {
        $this->sendgridApiKey = $sendgridApiKey;
    }

    /**
     * @inheritDoc
     */
    public function send(array $data)
    {
        try {
            $email = new Mail();
            $email->setFrom(config('mail.from.address'), config('mail.from.name'));
            $email->setSubject($data['subject']);
            $email->addTo($data['to']);
            $email->addContent('text/plain', $data['message']);

            (new SendGridClient($this->sendgridApiKey))->send($email);

            $this->log($data);
            SentEmail::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @inheritDoc
     */
    public function log(array $data)
    {
        Log::info('E-mail sent to ' . $data['to'] . ' using ' . get_called_class() . ' on ' . Carbon::now());
    }
}
