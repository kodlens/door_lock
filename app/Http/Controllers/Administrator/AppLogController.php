<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppLog;

class AppLogController extends Controller
{
    //

    public function index(){
        return view('administrator.logs');
    }

    public function getLogs(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = AppLog::orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function getAttendanceLogs(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = AppLog::where('log_type', 'ATTENDANCE')->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }
}
