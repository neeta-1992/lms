<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Str;
use App\Console\Commands\CompanyInstall;
use App\Models\{
    ScheduledTaskList
};

class Kernel extends ConsoleKernel
{

    
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\QuoteAccountStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


       
       $scheduledTaskList = ScheduledTaskList::getData(["status"=>1])->get();

        if(!empty($scheduledTaskList)){
             foreach ($scheduledTaskList as $key => $value) {
                $taskNameArr = taskName(['isAdmin'=>true]);

                $type       = $value?->task_name ?? null ;
                $type       = array_search($type,$taskNameArr);

                $time       = !empty($value->start_time) ? date("H:i",strtotime($value->start_time)) : "23:56" ;
                $startDate  = !empty($value->start_date) ? date("Y-m-d",strtotime($value->start_date)) : "" ;
                $usTimeZone = !empty($value->us_time_zone) ? $value->us_time_zone : config("app.timezone");
                $time       = $value?->task_name ?? null ;
                $howOften   = $value?->how_often ?? null ;
                $timeFunction = "daily";
                $functionConf = $time;
                if($howOften == "daily"){
                    $timeFunction = "daily";
                }elseif($howOften == "daily_excluding_weekends"){
                    $timeFunction = "days";
                    $functionConf = [1,5];
                }elseif($howOften == "weekly"){
                    $timeFunction = "weekly";
                }elseif($howOften == "monthly"){
                    $timeFunction = "monthly";
                }

              //  $timeFunction = "everyMinute";
              //  $functionConf = null;
                switch ($type) {
                    case 'company_setup':
                        $schedule->command(CompanyInstall::class)->{$timeFunction}($functionConf)
                            ->appendOutputTo(storage_path('logs/inspire.log'))
                            ->timezone($usTimeZone)->withoutOverlapping()
                            ->runInBackground()
                            ->emailOutputOnFailure('neetaagrawal19@gmail.com');
                        break;
                    default:
                        # code...
                        break;
                }
             }
        }

        $schedule->command('account-status:cron')  ->everyMinute();

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
