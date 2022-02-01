<?php

namespace App\Console;

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
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = storage_path('logs/schedule.log');

        // Update statistics
        $schedule->command('update:statistics')->daily()->at('01:00')->appendOutputTo($filePath);

        // Take a daily backup
        $schedule->command('backup:clean')->daily()->at('01:00')->appendOutputTo($filePath);
        $schedule->command('backup:run')->daily()->at('02:00')->appendOutputTo($filePath);

        // Send email to the organizers that have expiring events.
        $schedule->command('mail:sendEmailToExpiringEventsOrganizers')->daily()->at('01:00')->appendOutputTo($filePath);

        // $schedule->command('inspire')->hourly();
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
