<?php

namespace Xetaravel\Console;

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

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('servers:refresh')
            ->everyMinute()
            ->withoutOverlapping(30)
            ->runInBackground();
            //->appendOutputTo('/srv/users/arkdivision/apps/discuss/storage/logs/scheduler.log');

        // Dont run the schedule command on dev mode.
        if (env('APP_ENV') != 'local') {
            $schedule->command('message:player')
                ->everyMinute()
                ->runInBackground();

            $schedule->command('players:refresh')
                ->everyMinute()
                ->runInBackground()
                ->withoutOverlapping();

            $schedule->command('member:validation')
                ->everyMinute()
                ->runInBackground();

            $schedule->command('steamban:checker')
                ->hourly()
                ->runInBackground();

            $schedule->command('division:stats')
                ->monthlyOn(24, '19:00')
                ->runInBackground();

            $schedule->command('coffres:refreshdaily')
                ->dailyAt('00:00')
                ->runInBackground();

            $schedule->command('coffres:refreshmonthly')
                ->monthly()
                ->runInBackground();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
