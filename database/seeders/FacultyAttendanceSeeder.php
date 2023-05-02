<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FacultyAttendanceSeeder extends Seeder
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
                'user_id' => 2,
                'rfid' => 'abcd123',
                'user_name' => 'DELA CRUZ, JUAN ',
                'role' => 'FACULTY',
                'door_id' => 2,
                'schedule_id' => 1,
                'attendance_date' => '2023-05-02',
                'log_type' => 'ATTENDANCE'

            ],
            [
                'user_id' => 2,
                'rfid' => 'abcd123',
                'user_name' => 'DELA CRUZ, JUAN ',
                'role' => 'FACULTY',
                'door_id' => 2,
                'schedule_id' => 2,
                'attendance_date' => '2023-05-02',
                'log_type' => 'ATTENDANCE'

            ],
            [
                'user_id' => 2,
                'rfid' => 'abcd123',
                'user_name' => 'DELA CRUZ, JUAN ',
                'role' => 'FACULTY',
                'door_id' => 2,
                'schedule_id' => 3,
                'attendance_date' => '2023-05-02',
                'log_type' => 'ATTENDANCE'

            ],
            [
                'user_id' => 2,
                'rfid' => 'abcd123',
                'user_name' => 'DELA CRUZ, JUAN ',
                'role' => 'FACULTY',
                'door_id' => 2,
                'schedule_id' => 1,
                'attendance_date' => '2023-05-03',
                'log_type' => 'ATTENDANCE'

            ],
            [
                'user_id' => 2,
                'rfid' => 'abcd123',
                'user_name' => 'DELA CRUZ, JUAN ',
                'role' => 'FACULTY',
                'door_id' => 2,
                'schedule_id' => 2,
                'attendance_date' => '2023-05-03',
                'log_type' => 'ATTENDANCE'

            ],
       
        ];

        \App\Models\FacultyAttendance::insertOrIgnore($data);

    }
}
