<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
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
                'ay_code' => '20212022-1',
                'ay_desc' => 'ACADEMIC YEAR 2021 - 2022',
                'semester' => '1ST SEMESTER',
                'active' => 0
            ],
            [
                'ay_code' => '20212022-2',
                'ay_desc' => 'ACADEMIC YEAR 2021 - 2022',
                'semester' => '2ND SEMESTER',
                'active' => 0
            ],

            [
                'ay_code' => '20222023-1',
                'ay_desc' => 'ACADEMIC YEAR 2022 - 2023',
                'semester' => '1ST SEMESTER',
                'active' => 1
            ],
            [
                'ay_code' => '20222023-2',
                'ay_desc' => 'ACADEMIC YEAR 2022 - 2023',
                'semester' => '2ND SEMESTER',
                'active' => 0
            ],
            

        ];

        \App\Models\AcademicYear::insertOrIgnore($data);
    }
}
