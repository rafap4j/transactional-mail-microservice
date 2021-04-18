<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Sent e-mail message model.
 *
 * @package App\Models
 *
 * @property  int  $id  Sent e-mail message ID.
 * @property  string  $to  Sent e-mail message destination address.
 * @property  string  $subject  Sent e-mail message subject.
 * @property  string  $body  Sent e-mail message body.
 * @property  string  $service  Service name used to send the e-mail message.
 */
class SentEmail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to',
        'subject',
        'body',
        'service',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function (SentEmail $sentEmail) {
            $sentEmail->service = config('mail.default_email_service');
        });
    }
}
