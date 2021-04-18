<?php

namespace Tests\Feature;

use App\Jobs\SendEmail;
use Exception;
use Tests\TestCase;

class SendEmailTest extends TestCase
{
    /**
     * Send an e-mail message using valid recipient's
     * address, subject and message body.
     *
     * @return void
     */
    public function send_an_email_with_valid_data()
    {
        $data = \App\Models\SentEmail::factory()->definition();

        $this->json('POST', route('email.send'), $data, [
            'Content-Type' => 'application/json',
        ])->assertStatus(200);

        $this->assertDatabaseHas('sent_emails', $data);
    }

    /**
     * Send an e-mail message using the default service.
     *
     * @return void
     */
    public function send_an_email_using_default_email_service()
    {
        $data = \App\Models\SentEmail::factory()->definition();

        $response = $this->json('POST', route('email.send'), $data, [
            'Content-Type' => 'application/json',
        ]);

        $this->assertEquals(
            $response['data']['message']['service'],
            config('mail.default_email_service')
        );
    }

    /**
     * Send an e-mail message using a fallback service.
     *
     * @return void
     */
    public function send_an_email_using_fallback_email_service()
    {
        $defaultEmailService = config('mail.default_email_service');

        $data = \App\Models\SentEmail::factory()->definition();
        (new SendEmail($data))->failed(new Exception());

        $response = $this->json('POST', route('email.send'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $this->assertEquals(
            $response['data']['message']['service'],
            $defaultEmailService
        );
    }
}
