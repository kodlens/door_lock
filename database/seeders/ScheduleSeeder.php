<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id' => 3, 
                'door_id' => 2, 
                'ay_id' => 1, 
                'time_start'=>'02:04:00', 
                'time_end'=>'14:02:00', 
                'mon'=>0, 
                'tue'=>1,
                'wed'=>0,
                'thu'=>0,
                'fri'=>1,
                'sat'=>0,
                'sun'=>0,
            ],

            [
                'user_id' => 4, 
                'door_id' => 3, 
                'ay_id' => 1, 
                'time_start'=>'11:10:00', 
                'time_end'=>'15:00:00', 
                'mon'=>0, 
                'tue'=>1,
                'wed'=>0,
                'thu'=>0,
                'fri'=>0,
                'sat'=>1,
                'sun'=>0,
            ],
        ];

        \App\Models\Schedule::insertOrIgnore($data);
    }
}
