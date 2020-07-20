<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\SubDomain;

class Register
{
    public function __invoke(RegisterRequest $request)
    {

        SubDomain::create([
            'name' => $request->input('sub_domain'),
            'email' => $request->input('email'),
        ]);

        return view('home', [
            'message' => 'Successfully registered sub domain. Please verify email to activate.'
        ]);
    }
}
