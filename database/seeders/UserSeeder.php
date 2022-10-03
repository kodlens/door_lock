<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'username' => 'admin',
                'lname' => 'GERONA',
                'fname' => 'XIAN',
                'mname' => '',
                'sex' => 'MALE',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],

            [
                'username' => 'user01',
                'lname' => 'DELA CRUZ',
                'fname' => 'JUAN',
                'mname' => '',
                'sex' => 'MALE',
                'role' => 'USER',
                'password' => Hash::make('a')
            ],


        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
