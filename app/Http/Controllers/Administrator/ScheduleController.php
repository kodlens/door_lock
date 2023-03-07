<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AcademicYear;
use App\Models\User;
use App\Models\Door;
use App\Models\Schedule;



class ScheduleController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.schedule.schedule');
    }


    public function getBrowseEmployees(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = User::where('lname', 'like', $req->lname . '%')
            ->where('role', 'EMPLOYEE')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function getBrowseDoors(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Door::where('door_name', 'like', $req->door . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }



    public function getSchedules(Request $req){
        //return $req;

        $sort = explode('.', $req->sort_by);

        $data = Schedule::with(['user','door','ay'])->orderBy($sort[0], $sort[1])
            ->whereHas('user', function($q) use ($req){
                $q->where('lname', 'like', $req->lname . '%'); //-> select * from users where users.lname like "DELA CRUZ%"
            })
            ->paginate($req->perpage);

        return $data;

    }


    
    public function create(){
        $academicYears = AcademicYear::orderBy('ay_code', 'asc')->get();

        return view ('administrator.schedule.schedule-create')
            ->with('academicYears', $academicYears)
            ->with('schedule', '')
            ->with('id', 0);
    }


    public function store(Request $req){
        // return $req;

        $timeFrom = date("H:i:s", strtotime($req->time_from)); //convert to date format UNIX
        $timeTo = date("H:i:s", strtotime($req->time_to)); //convert to date format UNIX

        $req->validate([
            'ay_id' => ['required'],
            'door_id' => ['required'],
            'user_id' => ['required'],
            'time_from' => ['required'],
            'time_to' => ['required']
        ], [
            'ay_id.required' => 'Please select academic year.',
            'door_id.required' => 'Please select door.',
            'user_id.required' => 'Please select user.',
        ]);

        //store data
        Schedule::create([
            'user_id' => $req->user_id,
            'door_id' => $req->door_id,
            'ay_id' => $req->ay_id,
            'time_start' => $timeFrom,
            'time_end' => $timeTo,
            'mon' => $req->mon,
            'tue' => $req->tue,
            'wed' => $req->wed,
            'thu' => $req->thu,
            'fri' => $req->fri,
            'sat' => $req->sat,
            'sun' => $req->sun,

        ]);
        return response()->json([
            'status' => 'saved'
        ],200);

    }


    public function edit($id){
        $academicYears = AcademicYear::orderBy('ay_code', 'asc')->get();
        $schedule = Schedule::with(['user', 'door', 'ay'])
            ->find($id);

        return view ('administrator.schedule.schedule-create')
            ->with('academicYears', $academicYears)
            ->with('schedule', $schedule)
            ->with('id', $id);
    }

    public function update(Request $req, $id){
        //return $req;

        $req->validate([
            'ay_id' => ['required'],
            'door_id' => ['required'],
            'user_id' => ['required'],
            'time_from' => ['required'],
            'time_to' => ['required']
        ], [
            'ay_id.required' => 'Please select academic year.'
        ]);

        $timeFrom = date("H:i:s", strtotime($req->time_from)); //convert to date format UNIX
        $timeTo = date("H:i:s", strtotime($req->time_to)); //convert to date format UNIX

        Schedule::where('schedule_id', $id)
            ->update([
                'user_id' => $req->user_id,
                'door_id' => $req->door_id,
                'ay_id' => $req->ay_id,
                'time_start' => $timeFrom,
                'time_end' => $timeTo,
                'mon' => $req->mon,
                'tue' => $req->tue,
                'wed' => $req->wed,
                'thu' => $req->thu,
                'fri' => $req->fri,
                'sat' => $req->sat,
                'sun' => $req->sun,
            ]);

        return response()->json([
            'status' => 'updated'
        ],200);

    }
    
    public function destroy($id){
        Schedule::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ],200);
    }


}
