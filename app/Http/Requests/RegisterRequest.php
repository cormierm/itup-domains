<?php

namespace App\Http\Requests;

use App\AllowedEmail;
use App\Rules\AvailableHostname;
use App\Rules\NotReservedIp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'hostname' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::notIn(config('itup.blocked_hostnames')),
                'regex:/^[a-z0-9-]+$/i',
                new AvailableHostname,
            ],
            'ip' => [
                'required',
                'ipv4',
                new NotReservedIp,
            ],
            'email' => [
                'required',
                'email',
                'ends_with:' . AllowedEmail::all()->pluck('email')->join(','),
            ],
            'expires_in' => 'required|integer|between:1,30',
        ];
    }

    public function messages()
    {
        return [
            'email.ends_with' => 'The email provided is blocked. Please try another email.'
        ];
    }
}
