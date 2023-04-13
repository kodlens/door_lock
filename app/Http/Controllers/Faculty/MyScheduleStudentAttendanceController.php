<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\ScheduleStudentList;

class MyScheduleStudentAttendanceController extends Controller
{
    //

    public function index($sId){
        $schedule = Schedule::with(['ay'])->find($sId);

        return view('faculty.my-schedule-student-attendance')
            ->with('schedule', $schedule);
    }
    
    public function getAll(Request $req){
        //$sort = explode('.', $req->sort_by);

        //$user_id = Auth::user()->user_id;
        $schedule_id = $req->scheduleid;

        $data = ScheduleStudentList::orderBy('student_lname', 'asc')
            ->where('schedule_id', $schedule_id)
            ->get();

        return $data;
    }   
    


}