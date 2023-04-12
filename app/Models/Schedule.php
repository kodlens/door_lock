<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $primaryKey = 'schedule_id';
    protected $fillable = [
        'user_id', 
        'door_id', 
        'ay_id', 
        'time_start', 
        'time_end', 
        'mon', 
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun',

    ];

    public function user(){
        return $this->hasOne(User::class,'user_id','user_id');
        
    }
    public function door(){
        return $this->hasOne(Door::class,'door_id','door_id');
    }
    public function ay(){
        return $this->hasOne(AcademicYear::class,'ay_id','ay_id');
    }


    public function student_list(){
        return $this->hasMany(ScheduleStudentList::class,'schedule_id','schedule_id');
    }


}
