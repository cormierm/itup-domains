<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'sub_domain' => 'required|string|min:2|unique:sub_domains,name',
            'email' => 'required|email',
        ];
    }
}
