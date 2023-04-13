<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $primaryKey = 'attendance_id';


    protected $fillable = [
        'user_id', 
        'ay_id', 
        'attendance_datetime', 
        'attendance_remark',
    ];


    public function user(){
        return $this->hasOne(User::class,'user_id','user_id');
    }
 
    public function ay(){
        return $this->hasOne(AcademicYear::class,'ay_id','ay_id');
    }

    public function schedule(){
        return $this->hasOne(Schedule::class,'schedule_id','schedule_id');
    }

    public function student_attendance(){
        return $this->hasMany(AttendanceStudent::class,'attendance_id','attendance_id');
    }

}
