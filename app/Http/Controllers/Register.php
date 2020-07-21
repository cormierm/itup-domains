<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\SubDomain;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Register
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {

        $subDomain = SubDomain::create([
            'name' => $request->input('sub_domain'),
            'email' => $request->input('email'),
            'ip' => $request->input('ip'),
            'token' => (string) Str::uuid()
        ]);

        Mail::to($subDomain->email)->send(new \App\Mail\Register($subDomain));

        return new JsonResponse([
            'message' => 'Successfully registered sub domain. Please verify email to activate.'
        ]);
    }
}
