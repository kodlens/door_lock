<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Models\Schedule;
use Auth;


class MyAttendanceController extends Controller
{
    //

    public function index(){
        return view('faculty.my-attendances');
    }

    public function getAll(Request $req){

        $sort = explode('.', $req->sort_by);

        $user_id = Auth::user()->user_id;

        $data = Attendance::with(['ay'])
            ->where('user_id', $user_id)
            ->where('ay_id', 'like', $req->ay . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function create(){
        $user = Auth::user();
        $academicYears = AcademicYear::all();
        $schedules = Schedule::where('user_id', $user->user_id)
            ->get();

        return view('faculty.my-attendance-create')
            ->with('academicYears', $academicYears)
            ->with('schedules', $schedules);
    }

}