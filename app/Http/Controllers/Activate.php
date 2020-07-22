<?php

namespace App\Http\Controllers;

use App\Hostname;
use Carbon\Carbon;

class Activate
{
    public function __invoke(string $token)
    {
        $hostname = Hostname::query()
            ->where('token', $token)
            ->whereNull('verified_at')
            ->first();

        if (!$hostname) {
            return view('home', [
                'alert' => [
                    'type' => 'error',
                    'text' => 'There was a problem activating. This hostname may have been already activated.'
                ]
            ]);
        }

        $hostname->update([
            'verified_at' => Carbon::now()
        ]);

        return view('home', [
            'alert' => [
                'type' => 'success',
                'text' => 'Successfully activated hostname!'
            ]
        ]);
    }
}
