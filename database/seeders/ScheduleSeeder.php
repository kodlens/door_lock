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

            //test data for DOOR 2
            [
                'schedule_description' => 'ENGL 1',
                'user_id' => 2, 
                'door_id' => 2, 
                'ay_id' => 3, 
                'time_start'=>'08:00:00', 
                'time_end'=>'10:00:00', 
                'mon'=>1, 
                'tue'=>0,
                'wed'=>1,
                'thu'=>0,
                'fri'=>1,
                'sat'=>0,
                'sun'=>0,
            ],

            [
                'schedule_description' => 'COMP 100',
                'user_id' => 2, 
                'door_id' => 2, 
                'ay_id' => 3, 
                'time_start'=>'10:00:00', 
                'time_end'=>'12:00:00', 
                'mon'=>1, 
                'tue'=>0,
                'wed'=>1,
                'thu'=>0,
                'fri'=>1,
                'sat'=>0,
                'sun'=>0,
            ],
            [
                'schedule_description' => 'COMP 112',
                'user_id' => 2, 
                'door_id' => 2, 
                'ay_id' => 3, 
                'time_start'=>'13:00:00', 
                'time_end'=>'03:00:00', 
                'mon'=>1, 
                'tue'=>0,
                'wed'=>1,
                'thu'=>0,
                'fri'=>1,
                'sat'=>0,
                'sun'=>0,
            ],
            [
                'schedule_description' => 'TEST SUBJ',
                'user_id' => 2, 
                'door_id' => 2, 
                'ay_id' => 3, 
                'time_start'=>'17:00:00', 
                'time_end'=>'23:00:00', 
                'mon'=>1, 
                'tue'=>0,
                'wed'=>1,
                'thu'=>0,
                'fri'=>1,
                'sat'=>0,
                'sun'=>0,
            ],





            //another test data for another DOOR
            [
                'schedule_description' => 'PHILO 1',
                'user_id' => 4, 
                'door_id' => 2, 
                'ay_id' => 1, 
                'time_start'=>'08:10:00', 
                'time_end'=>'17:00:00', 
                'mon'=>0, 
                'tue'=>1,
                'wed'=>0,
                'thu'=>1,
                'fri'=>1,
                'sat'=>1,
                'sun'=>0,
            ],
        ];

        \App\Models\Schedule::insertOrIgnore($data);
    }
}
