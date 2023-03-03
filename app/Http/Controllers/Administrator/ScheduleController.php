<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AcademicYear;
use App\Models\User;
use App\Models\Door;

class ScheduleController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.schedule.schedule');
    }


    public function create(){
        $academicYears = AcademicYear::orderBy('ay_code', 'asc')->get();

        return view ('administrator.schedule.schedule-create')
            ->with('academicYears', $academicYears);
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

    public function store(Request $req){
        return $req;

        $timeFrom = date("H:i:s", strtotime($req->time_from)); //convert to date format UNIX
        $timeTo = date("H:i:s", strtotime($req->time_to)); //convert to date format UNIX

        //store data
    }


}
