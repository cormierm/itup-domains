<?php

namespace App\Http\Requests;

use App\Rules\HostnameMustMatchEmail;
use App\Rules\NotReservedIp;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'hostname' => [new HostnameMustMatchEmail($this->input('email'))],
            'ip' => [
                'required',
                'ipv4',
                new NotReservedIp,
            ],
            'expires_in' => 'required|integer|between:1,30',
        ];
    }
}
