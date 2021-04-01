<?php

namespace App\Http\Controllers;

use App\Hostname;
use App\Http\Requests\UpdateRequest;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Update extends Controller
{

    public function __invoke(UpdateRequest $request)
    {
        $hostname = Hostname::query()
            ->where('name', $request->input('hostname'))
            ->where('email', $request->input('email'))
            ->first();

        $transaction = Transaction::create([
            'action' => 'update',
            'details' => json_encode([
                'hostname_id' => $hostname->id,
                'ip' => $request->input('ip'),
                'expires_at' => Carbon::now()->addDays($request->input('expires_in')),
            ]),
            'token' => (string) Str::uuid(),
        ]);

        Mail::to($hostname->email)->send(new \App\Mail\Update($transaction));

        return new JsonResponse([
            'message' => 'Successfully submitting hostname update. Please verify email to activate changes.',
        ]);
    }
}
