<?php

namespace App\Console;

use App\Console\Commands\CheckAds;
use App\Console\Commands\CheckTrial;
use App\Console\Commands\ClearStatistics;
use App\Console\Commands\PlaylistLoop;
use App\Console\Commands\SendEmails;
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
        SendEmails::class,
        PlaylistLoop::class,
        CheckAds::class,
        CheckTrial::class,
        ClearStatistics::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('send_emails')
            ->everyTenMinutes();
        $schedule->command('playlist_loop')
            ->everyMinute();
        $schedule->command('check_ads')
            ->twiceDaily(12, 23);
        $schedule->command('check_trial')
            ->twiceDaily(12, 23);
        $schedule->command('clear_statistics')
            ->monthly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
