<?php

namespace App\Jobs;

use App\Hostname;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteExpiredHostnames implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        Hostname::query()
            ->where('expires_at', '<', Carbon::now()->subWeek())
            ->each(function($hostname) {
                DeleteRecordSet::dispatch($hostname);
            });
    }
}
