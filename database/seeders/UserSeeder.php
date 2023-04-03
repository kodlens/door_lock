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
                'rfid' => '',
                'username' => 'admin',
                'lname' => 'GERONA',
                'fname' => 'XIAN',
                'mname' => '',
                'sex' => 'MALE',
                'role' => 'ADMINISTRATOR',
                'card_type' => 'MASTER CARD',
                'password' => Hash::make('a')
            ],


            [
                'rfid' => 'abcd123',
                'username' => 'juan',
                'lname' => 'DELA CRUZ',
                'fname' => 'JUAN',
                'mname' => '',
                'sex' => 'MALE',
                'role' => 'FACULTY',
                'card_type' => 'USER CARD',
                'password' => Hash::make('a')
            ],
            [
                'rfid' => '31254',
                'username' => 'nevitt',
                'lname' => 'Dale',
                'fname' => 'Nevitt',
                'mname' => '',
                'sex' => 'MALE',
                'role' => 'FACULTY',
                'card_type' => 'USER CARD',
                'password' => Hash::make('a')
            ],
    
            [
                'rfid' => '3214',
                'username' => 'faichid',
                'lname' => 'norma',
                'fname' => 'faichid',
                'mname' => '',
                'sex' => 'MALE',
                'role' => 'FACULTY',
                'card_type' => 'USER CARD',
                'password' => Hash::make('a')
              
            ],
            [
                'rfid' => '316asdm',
                'username' => 'faichid',
                'lname' => 'Barber',
                'fname' => 'Phillip',
                'mname' => '',
                'sex' => 'MALE',
                'role' => 'FACULTY',
                'card_type' => 'USER CARD',
                'password' => Hash::make('a')
            ],

           


        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
