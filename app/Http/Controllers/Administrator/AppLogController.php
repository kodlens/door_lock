<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppLog;
use App\Models\FacultyAttendance;

class AppLogController extends Controller
{
    //

    public function index(){
        return view('administrator.logs');
    }

    public function getLogs(Request $req){
        $sort = explode('.', $req->sort_by);

        $key = '';
        if(isset($req->user)){
            $key = $req->user;   
        }

        $data = AppLog::where('user', 'like', '%' . $key . '%')
            ->whereBetween('created_at', [$req->start . ' 00:00:00', $req->end . ' 23:59:59']) //added time to do trick
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function logsPrintPreview(Request $req){
        $key = '';
        if(isset($req->user)){
            $key = $req->user;   
        }
        $data = AppLog::where('user', 'like', '%' . $key . '%')
            ->whereBetween('created_at', [$req->start . ' 00:00:00', $req->end . ' 23:59:59']) //added time to do trick
            ->get();

        return view('administrator.logs-print-preview')
            ->with('data', $data)
            ->with('start', $req->start)
            ->with('end', $req->end);
    }

    public function getAttendanceLogs(Request $req){
        $sort = explode('.', $req->sort_by);

        $key = '';
        if(isset($req->faculty)){
            $key = $req->faculty;   
        }

        $data = FacultyAttendance::with(['door', 'schedule', 'user'])
            ->where('user_name', 'like', '%' . $key . '%')
            ->whereBetween('attendance_date', [$req->start , $req->end]) //added time to do trick
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function logsAttendancePrintPreview(Request $req){

        $key = '';
        if(isset($req->faculty)){
            $key = $req->faculty;   
        }

        $data = FacultyAttendance::with(['door', 'schedule', 'user'])
            ->where('user_name', 'like', '%' . $key . '%')
            ->whereBetween('attendance_date', [$req->start , $req->end]) //added time to do trick
            ->get();

        //return $data;


            return view('administrator.log-attendance-print-preview')
            ->with('data', $data)
            ->with('start', $req->start)
            ->with('end', $req->end);
    }

}
