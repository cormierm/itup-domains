<?php

namespace App\Http\Controllers;

class Edit extends Controller
{
    public function __invoke(string $hostname)
    {
        return view('edit', ['hostname' => $hostname]);
    }
}
