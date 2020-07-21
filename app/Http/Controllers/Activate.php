<?php

namespace App\Http\Controllers;

use App\SubDomain;
use Carbon\Carbon;

class Activate
{
    public function __invoke(string $token)
    {
        $subDomain = SubDomain::query()
            ->where('token', $token)
            ->whereNull('verified_at')
            ->first();

        if (!$subDomain) {
            return view('home', [
                'alert' => [
                    'type' => 'error',
                    'text' => 'There was a problem activating. This sub domain may have been already activated.'
                ]
            ]);
        }

        $subDomain->update([
            'verified_at' => Carbon::now()
        ]);

        return view('home', [
            'alert' => [
                'type' => 'success',
                'text' => 'Successfully activated sub domain!'
            ]
        ]);
    }
}
