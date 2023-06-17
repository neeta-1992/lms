<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ScheduledTask;
class ScheduledTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $inserArr =[
            'task_name'       => 'company_setup',
            'user_id'         => 1,
            'how_often'       => "daily",
            'us_time_zone'    => config("app.timezone"),
            'start_time'      => "12:00 AM",
            'start_date'      => "",
            'description'     => "",
            'end_date'        => "",
            'status'          => 1,
            'is_admin'        => 1,
        ];
        $ScheduledTask = ScheduledTask::whereEn("task_name",'company_setup')->first();
        if(!empty($inserArr) && empty($ScheduledTask)){
            ScheduledTask::insertOrUpdate($inserArr);
        }else{
            $inserArr['id'] = $ScheduledTask?->id;
            ScheduledTask::insertOrUpdate($inserArr);
        }
    }
}
