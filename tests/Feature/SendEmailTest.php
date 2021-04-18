<?php

namespace Tests\Feature;

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
}
