<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\IndexEmbeddings;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
     protected $commands = [
        // سجل الأمر هنا
        IndexEmbeddings::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('embeddings:index')
                 ->dailyAt('02:00')
                 ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
