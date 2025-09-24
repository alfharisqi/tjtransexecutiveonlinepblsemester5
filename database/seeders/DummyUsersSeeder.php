<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [   
                'id' => 1,
                'name'=>'Admin TJ Trans',
                'email'=>'admintjtransexeutive@gmail.com',
                'role'=>'admin',
                'email_verified_at'=> now(),
                'password'=>bcrypt('tjtransexeutiveonline'),
            
            ]

            ];

            foreach($userData as $key => $val){
                User::create($val);
            }
    }
}