<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Hostname;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Register
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {

        $hostname = Hostname::create([
            'name' => $request->input('hostname'),
            'email' => $request->input('email'),
            'ip' => $request->input('ip'),
            'token' => (string) Str::uuid()
        ]);

        Mail::to($hostname->email)->send(new \App\Mail\Register($hostname));

        return new JsonResponse([
            'message' => 'Successfully registered hostname. Please verify email to activate.'
        ]);
    }
}
