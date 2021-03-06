<?php

namespace App\Console;

use App\Jobs\DeleteExpiredHostnames;
use App\Jobs\DeleteUnactivatedHostnames;
use App\Jobs\SendMailForExpiredHostnames;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new DeleteUnactivatedHostnames)->everyMinute();
        $schedule->job(new DeleteExpiredHostnames)->everyMinute();
        $schedule->job(new SendMailForExpiredHostnames)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
