<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ScheduleStudentListSeeder extends Seeder
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
                'student_id' => '20231234', 
                'schedule_id' => 1, 
                'student_lname' => 'SMITH', 
                'student_fname' => 'JOHN', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'MALE', 
                'student_contact_no' => '09154214542', 
               
            ],
            [
                'student_id' => '20231212', 
                'schedule_id' => 1, 
                'student_lname' => 'DOE', 
                'student_fname' => 'JOHN', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'MALE', 
                'student_contact_no' => '09154214649', 
               
            ],
            [
                'student_id' => '20231212', 
                'schedule_id' => 1, 
                'student_lname' => 'PANGABE', 
                'student_fname' => 'JED', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'MALE', 
                'student_contact_no' => '09705569743', 
            ],
            [
                'student_id' => '20231213', 
                'schedule_id' => 1, 
                'student_lname' => 'SY', 
                'student_fname' => 'MENCHIE', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'FEMALE', 
                'student_contact_no' => '09705566544', 
            ],
            [
                'student_id' => '20231214', 
                'schedule_id' => 1, 
                'student_lname' => 'LICERA', 
                'student_fname' => 'RICHIE', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'MALE', 
                'student_contact_no' => '09276659910', 
            ],




            [
                'student_id' => '20231215', 
                'schedule_id' => 2, 
                'student_lname' => 'LARIDE', 
                'student_fname' => 'HONEY JANE', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'FEMALE', 
                'student_contact_no' => '09276659556', 
            ],
            [
                'student_id' => '20231216', 
                'schedule_id' => 2, 
                'student_lname' => 'TENDA', 
                'student_fname' => 'TREXY', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'FEMALE', 
                'student_contact_no' => '09276659589', 
            ],
            [
                'student_id' => '20231217', 
                'schedule_id' => 2, 
                'student_lname' => 'PALER', 
                'student_fname' => 'BERT', 
                'student_mname' => '', 
                'student_suffix' => '', 
                'student_sex' => 'MALE', 
                'student_contact_no' => '09395369111', 
            ],

       
        ];

        \App\Models\ScheduleStudentList::insertOrIgnore($data);

    }
}
