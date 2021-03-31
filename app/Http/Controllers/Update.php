<?php

namespace App\Http\Controllers;

class Update extends Controller
{
    public function __invoke(string $hostname)
    {
        return view('update', ['hostname' => $hostname]);
    }
}
