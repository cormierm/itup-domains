<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hostname' => 'required|string|min:2|max:50|regex:/^[a-z0-9-]+$/i|unique:hostnames,name',
        ];
    }
}
