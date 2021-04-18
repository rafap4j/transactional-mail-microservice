<?php

namespace App\Services;

use App\Services\Interfaces\EmailHandler;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Mailjet\Client;
use Mailjet\Resources;

/**
 * Mailjet e-mail handler class.
 *
 * @package App\Services
 */
class MailjetEmailHandler implements EmailHandler
{
    /**
     * Mailjet API key.
     *
     * @var string
     */
    private $mailjetApiKey;

    /**
     * Mailjet secret key.
     *
     * @var string
     */
    private $mailjetSecretKey;

    /**
     * Class constructor.
     *
     * @param  string  $mailjetApiKey
     * @param  string  $mailjetSecretKey
     */
    public function __construct(string $mailjetApiKey, string $mailjetSecretKey)
    {
        $this->mailjetApiKey = $mailjetApiKey;
        $this->mailjetSecretKey = $mailjetSecretKey;
    }

    /**
     * @inheritDoc
     */
    public function send(array $data)
    {
        $mailjetClient = new Client(
            $this->mailjetApiKey,
            $this->mailjetSecretKey,
            true,
            ['version' => 'v3.1']
        );

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => config('mail.from.address'),
                        'Name' => config('mail.from.name'),
                    ],
                    'To' => [
                        ['Email' => $data['to']]
                    ],
                    'Subject' => $data['subject'],
                    'TextPart' => $data['body'],
                ]
            ]
        ];

        try {
            $response = $mailjetClient->post(Resources::$Email, compact('body'));

            if ($response->success()) {
                $this->log($data);
            }
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
