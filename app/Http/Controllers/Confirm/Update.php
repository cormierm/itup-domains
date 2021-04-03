<?php

namespace App\Http\Controllers\Confirm;

use App\Hostname;
use App\Http\Controllers\Controller;
use App\Jobs\UpdateRecordSet;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Update extends Controller
{

    public function __invoke(Request $request, string $token)
    {

        $transaction = Transaction::query()
            ->where('token', $token)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->firstOrFail();
        $details = json_decode($transaction->details, true);

        $hostname = Hostname::query()->findOrFail($details['hostname_id']);

        $hostname->update(['expires_at' => Carbon::parse($details['expires_at'])]);

        if ($hostname->ip !== $details['ip']) {
            UpdateRecordSet::dispatch($transaction);
        }

        $transaction->delete();

        return redirect()
            ->route('home')
            ->with('alert', [
                'type' => 'success',
                'text' => 'Successfully applied changes to hostname!',
            ]);
    }
}
