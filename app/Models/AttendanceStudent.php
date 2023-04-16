<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    use HasFactory;


    protected $table = 'attendance_students';
    protected $primaryKey = 'attendance_student_id';


    protected $fillable = [
        'attendance_id', 
        'student_id', 
        'student_lname', 
        'student_fname',
        'student_suffix', 
        'student_sex', 
        'student_contact_no',
        'is_present'
    ];



}
