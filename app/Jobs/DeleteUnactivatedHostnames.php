<?php

namespace App\Jobs;

use App\Hostname;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteUnactivatedHostnames implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {

        Hostname::query()
            ->whereNull('verified_at')
            ->where('created_at', '<', Carbon::now()->subDay())
            ->delete();
    }
}
