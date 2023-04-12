<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentListController extends Controller
{
    //

    public function index($id){
        return view('faculty.student-list')
        ->with('schedule_id', $id);
    }


    
    public function store(Request $req){
    
    }
}
