<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =User::where("email",'admin@admin.com')->first();
        $inserArr =[
            'username'      => 'admin',
            'first_name'    => 'admin',
            'middle_name'   => 'admin',
            'last_name'     => 'admin',
            'mobile'        => '99999999',
            'email'         => 'admin@admin.com',
            'password'      => Hash::make(123456),
            'status'        => 1,
            'user_type'     => User::ADMIN,
        ];
        if(empty($data)){
            User::create($inserArr);
        }

    }
}
