<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyAttendance extends Model
{
    use HasFactory;

    protected $table = 'faculty_attendances';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id', 
        'rfid',
        'user_name',
        'role', 
        'door_id',
        'schedule_id',
        'attendance_date',
        'log_type'
    ];

    public function schedule(){
        return $this->hasOne(Schedule::class,'schedule_id','schedule_id');
    }

    public function door(){
        return $this->hasOne(Door::class,'door_id','door_id');
    }

    public function user(){
        return $this->hasOne(User::class,'user_id','user_id');
    }

}
