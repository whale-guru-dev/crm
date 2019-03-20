<?php

namespace App\Console;

use App\Console\Commands\BapInstall;
use App\Console\Commands\BapReseed;
use App\Console\Commands\EmailTest;
use App\Console\Commands\ExtractTranslations;
use App\Console\Commands\NotificationTester;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Modules\SentEmails\LaravelDatabaseEmails\SendEmailsCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BapInstall::class,
        BapReseed::class,
        NotificationTester::class,
        ExtractTranslations::class,
        SendEmailsCommand::class,
        EmailTest::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::info('scheduler is running');

        $schedule->command('email:send')->everyMinute()->withoutOverlapping(5);
        $schedule->command('queue:work --tries=3')->everyMinute()->withoutOverlapping(5);
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

    protected function osProcessIsRunning($needle)
    {
        // get process status. the "-ww"-option is important to get the full output!
        exec('ps aux -ww', $process_status);

        // search $needle in process status
        $result = array_filter($process_status, function ($var) use ($needle) {
            return strpos($var, $needle);
        });

        // if the result is not empty, the needle exists in running processes
        if (!empty($result)) {
            return true;
        }
        return false;
    }
}
