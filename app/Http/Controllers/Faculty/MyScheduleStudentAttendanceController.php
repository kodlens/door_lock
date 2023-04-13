<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class MyScheduleStudentAttendanceController extends Controller
{
    //

    public function index($sId){
        $schedule = Schedule::find($sId);

        return view('faculty.my-schedule-student-attendance')
            ->with('schedule', $schedule);
    }
    
    public function getAll(Request $req){

        $sort = explode('.', $req->sort_by);

        $user_id = Auth::user()->user_id;

        $data = Attendance::where('user_id', $user_id)
            ->where('ay_id', 'like', $req->ay . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }
    


}