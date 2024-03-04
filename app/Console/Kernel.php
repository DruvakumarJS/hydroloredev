<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendNotifications;
use App\Jobs\SendEmailNotification;
use App\Jobs\CheckPODstatus;
use App\Jobs\SendPruningNotification;


class Kernel extends ConsoleKernel
{

    protected $commands = [
     Commands\SendNotifications::class,
     commands\CheckPODstatus::class,
     commands\SendPruningNotification::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    

    protected function schedule(Schedule $schedule)
    {
         
         // $schedule->job(new SendNotifications)->dailyAt('18:00');
          //$schedule->job(new SendEmailNotification)->everyTwoMinutes();
          //$schedule->job(new CheckPODstatus)->everySixHours($minutes = 0);
          //$schedule->job(new SendPruningNotification)->dailyAt('10:30');

          $schedule->command('daily:notification')->dailyAt('14:00');
          $schedule->command('pod:status')->hourly();
          $schedule->command('pruning:notification')->dailyAt('14:00');



         
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
