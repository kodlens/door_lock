<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //

    public function index(){
        return view('faculty.attendances');
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