<?php

namespace App\Applications\Api\v1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * E-mail send form request class.
 *
 * @package App\Applications\Api\v1\Http\Requests
 */
class EmailSendRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'to' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required',
        ];
    }
}
