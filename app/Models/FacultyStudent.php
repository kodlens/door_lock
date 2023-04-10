<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyStudent extends Model
{
    use HasFactory;



    protected $table = 'faculty_students';

    protected $primaryKey = 'faculty_student_id';
    protected $fillable = [
        'student_id',
        'faculty_id', 
        'student_lname', 
        'student_fname', 
        'student_mname', 
        'student_suffix',
        'student_sex',
        'student_contact_no', 
    ];


}
