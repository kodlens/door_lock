<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\ScheduleStudentList;

class MyScheduleStudentListController extends Controller
{
    //

    public function index($id){
        $schedule = Schedule::with(['user', 'door', 'ay'])->find($id);
        return view('faculty.my-schedule-student-list')
        ->with('schedule', $schedule);
    }

    public function show($id){
        return ScheduleStudentList::find($id);
    }
    
    public function getAll(Request $req){
        $sort = explode('.', $req->sort_by);

        //$user_id = Auth::user()->user_id;

        $data = ScheduleStudentList::where('student_lname', 'like', $req->lname . '%')
            ->where('schedule_id', $req->scheduleid)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }   


    public function store(Request $req){
        
        //return $req;
        $req->validate([
            'student_lname' => ['required'],
            'student_fname' => ['required'],
        ]);

        ScheduleStudentList::create([
            'student_id' => $req->student_id,
            'schedule_id' => $req->schedule_id,
            'student_lname' => strtoupper($req->student_lname),
            'student_fname' => strtoupper($req->student_fname),
            'student_mname' => strtoupper($req->student_mname),
            'student_suffix' => strtoupper($req->student_suffix),
            'student_sex' => strtoupper($req->student_sex),
            'student_contact_no' => $req->student_contact_no,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){
        $req->validate([
            'student_lname' => ['required'],
            'student_fname' => ['required'],
        ]);

        ScheduleStudentList::where('schedule_student_list_id', $id)
            ->update([
                'student_id' => $req->student_id,
                'schedule_id' => $req->schedule_id,
                'student_lname' => strtoupper($req->student_lname),
                'student_fname' => strtoupper($req->student_fname),
                'student_mname' => strtoupper($req->student_mname),
                'student_suffix' => strtoupper($req->student_suffix),
                'student_sex' => strtoupper($req->student_sex),
                'student_contact_no' => $req->student_contact_no,
            ]);

        return response()->json([
            'status' => 'updated'
        ], 200);
    }



    public function destroy($id){
        ScheduleStudentList::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }

}
