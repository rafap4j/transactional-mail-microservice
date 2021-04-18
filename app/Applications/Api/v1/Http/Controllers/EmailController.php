<?php

namespace App\Applications\Api\v1\Http\Controllers;

use App\Applications\Api\v1\Http\Requests\EmailSendRequest;
use App\Http\Controllers\Controller;

/**
 * E-mail controller class.
 *
 * @package App\Applications\Api\v1\Http\Controllers
 */
class EmailController extends Controller
{
    /**
     * Send the e-mail.
     *
     * @param  \App\Applications\Api\v1\Http\Requests\EmailSendRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function send(EmailSendRequest $request)
    {
    }
}
