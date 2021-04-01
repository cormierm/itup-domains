<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Edit extends Controller
{
    public function __invoke(Request $request)
    {
        return view('edit', ['hostname' => $request->input('hostname')]);
    }
}
