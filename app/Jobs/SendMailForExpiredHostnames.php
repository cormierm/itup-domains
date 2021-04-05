<?php

namespace App\Jobs;

use App\Hostname;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendMailForExpiredHostnames implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $expiredHostnames = Hostname::query()
            ->whereNotIn(
                'id',
                Transaction::query()
                    ->where('action', 'renew')
                    ->where('created_at', '>=', Carbon::now()->subWeek())
                    ->pluck('hostname_id')
            )
            ->where('expires_at', '<', Carbon::now())
            ->get();

        $expiredHostnames->each(function ($hostname) {
            $transaction = Transaction::create([
                'hostname_id' => $hostname->id,
                'action' => Transaction::ACTION_RENEW,
                'token' => (string)Str::uuid()
            ]);

            Mail::to($hostname->email)->send(new \App\Mail\Renew($transaction));
        });
    }
}
