<?php

namespace App\Console;

//use App\Console\Commands\RegisterUser;
use App\Console\Commands\RegisterAspirant;
use App\Console\Commands\TotalAspirantRegistered;
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
        // RegisterUser::class,
        RegisterAspirant::class,
        TotalAspirantRegistered::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('project:end_time_edit')->everyMinute()->withoutOverlapping();
        $schedule->command('sync:registeredAspirant')->everyFiveMinutes()->withoutOverlapping();
        //$schedule->command('sync:registeredAspirant')->everyMinute()->withoutOverlapping();
        $schedule->command('sync:totalAspirantRegistered')->everyMinute()->withoutOverlapping();
        //$schedule->command('sync:totalAspirantRegistered')->everyFiveMinutes()->withoutOverlapping();
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
