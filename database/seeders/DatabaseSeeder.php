<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $arr = [
            StateSeeder::class,
        ];
        if(config('database.default') == "mysql"){
           $arr2  = [
                AdminSeeder::class,
                ScheduledTaskSeeder::class,
           ];
           $arr = array_merge($arr2,$arr);
        };
        if(config('database.default') == "mysql"){
           $arr3  = [
                QuoteStatusSettingSeeder::class
           ];
           $arr = array_merge($arr,$arr3);
        };

        $this->call($arr);
    }
}
