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
        Commands\UploadData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = "/var/log/data_upload_cron.log";

        $schedule->command('upload:data')->everyMinute()->before(function () {
            $this->logMsg('data upload','STARTED');
         })
         ->after(function () {
             $this->logMsg('data upload', 'ENDING');

         }); ;
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

    private function logMsg($type, $status){
        echo  "\n".$status . ":" . $type . " at " . date("Y-m-d H:i:s") . "\n"; 
    }
}
