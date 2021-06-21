<?php

namespace App\Console;

use App\Console\Commands\StaticDay;
use App\Console\Commands\ChangingDaysOF;
use App\Console\Commands\AuctioTimeExpires;
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
        AuctioTimeExpires::class,
        StaticDay::class,
        ChangingDaysOF::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('user:expire')
                  ->everyMinute();

        $schedule->command('user:staticDayOf')
                 ->everyMinute();
        $schedule->command('user:ChangingDaysOF')
                 ->everyMinute();
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
