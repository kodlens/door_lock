<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class MyScheduleStudentListController extends Controller
{
    //

    public function index($id){
        $schedule = Schedule::with(['user', 'door', 'ay'])->find($id);
        return view('faculty.my-schedule-student-list')
        ->with('schedule', $schedule);
    }


    
    public function getAll(Request $req){
        $sort = explode('.', $req->sort_by);

        //$user_id = Auth::user()->user_id;

        $data = Schedule::orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }   


    public function store(Request $req){
    
    }
}
