<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{
    //


    public function index(){
        return view('administrator.faculty'); //blade.php
    }

    public function getFaculty(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Faculty::where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function show($id){
        return Faculty::find($id);
    }

    public function store(Request $req){
        //this will create random unique QR code
        $qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        $validate = $req->validate([
            'rfid' => ['required', 'max:50', 'unique:faculty'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
        ]);

        Faculty::create([
            'rfid' => $req->rfid,
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'suffix' => strtoupper($req->suffix),
            'sex' => $req->sex,
            'contact_no' => $req->contact_no,
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){
        $validate = $req->validate([

            'rfid' => ['required', 'max:50', 'unique:faculty,rfid,'.$id.',faculty_id'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'contact_no' => ['required', 'string', 'max:20'],

        ]);

        $data = Faculty::find($id);
        $data->rfid = $req->rfid;
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->suffix = strtoupper($req->suffix);
        $data->contact_no = $req->contact_no;
        $data->sex = $req->sex;

        $data->save();

        return response()->json([
            'status' => 'updated'
        ]);
    }




    public function destroy($id){
        Faculty::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ],200);
    }

  
}
