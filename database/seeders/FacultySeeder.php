<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
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
                'rfid' => 'abcd123',
                'lname' => 'DELA CRUZ',
                'fname' => 'JUAN',
                'mname' => '',
                'sex' => 'MALE',
            ],
            [
                'rfid' => '31254',
                'lname' => 'Dale',
                'fname' => 'Nevitt',
                'mname' => '',
                'sex' => 'MALE',
            ],
    
            [
                'rfid' => '3214',
                'lname' => 'norma',
                'fname' => 'faichid',
                'mname' => '',
                'sex' => 'MALE',
              
            ],
            [
                'rfid' => '316asdm',
                'lname' => 'Barber',
                'fname' => 'Phillip',
                'mname' => '',
                'sex' => 'MALE',
            ],


        ];

        \App\Models\Faculty::insertOrIgnore($data);
    }
}
