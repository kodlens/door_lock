<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleStudentList extends Model
{
    use HasFactory;


    protected $table = 'schedule_student_lists';
    protected $primaryKey = 'schedule_student_list_id';


    protected $fillable = ['student_id', 'schedule_id', 'student_lname', 'student_fname',
        'student_suffix', 'student_sex', 'student_contact_no'
    ];


}
