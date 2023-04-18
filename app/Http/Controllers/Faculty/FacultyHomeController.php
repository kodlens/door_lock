<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Auth;
use App\Models\AcademicYear;

class FacultyHomeController extends Controller
{
    //


    public function index(){
        $user = Auth::user();
        $ay = AcademicYear::where('active', 1)->first();

        $schedules = Schedule::with(['ay'])
            ->where('user_id', $user->user_id)
            ->get();

        return view('faculty.faculty-home')
            ->with('user', $user)
            ->with('ay', $ay)
            ->with('schedules', $schedules);

    }


}
