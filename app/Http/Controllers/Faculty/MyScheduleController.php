<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Schedule;


class MyScheduleController extends Controller
{
    //

    public function index(){
        return view('faculty.my-schedules');
    }

    public function getAll(Request $req){

        $sort = explode('.', $req->sort_by);

        $user_id = Auth::user()->user_id;

        $data = Schedule::with(['ay'])
            ->where('user_id', $user_id)
            ->where('ay_id', 'like', $req->ay . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

}
