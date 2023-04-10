<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyStudent;

class MyStudentController extends Controller
{
    //


    public function index(){
        return view('faculty.my-students');
    }

    public function getAll(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = FacultyStudent::where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    


    public function store(Request $req){
    
    }

    

    public function update(Request $req, $id){
    
    }




    public function destroy($id){
        
        FacultyStudent::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
