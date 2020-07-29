<?php

namespace App\Http\Requests;

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
                'unique:hostnames,name',
            ],
            'ip' => 'required|ipv4',
            'email' => 'required|email|ends_with:@vehikl.com',
        ];
    }

    public function messages()
    {
        return [
            'email.ends_with' => 'The email provided is blocked from registering. Please try another email.'
        ];
    }
}
