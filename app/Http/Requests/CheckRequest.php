<?php

namespace App\Http\Requests;

use App\Rules\AvailableHostname;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckRequest extends FormRequest
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
                new AvailableHostname
            ],
        ];
    }
}
