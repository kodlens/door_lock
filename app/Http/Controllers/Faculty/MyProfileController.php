<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Models\AppLog;

class MyProfileController extends Controller
{
    //

    public function index(){
        $user = Auth::user();
        return view('faculty.my-profile')
            ->with('user', $user);
    }



    public function resetPassword(Request $req){
        $id = Auth::user()->user_id;

        $req->validate([
            'password' => ['required', 'confirmed']
        ]);



        $user = User::find($id);
        $user->password = Hash::make($req->password);
        $user->save();

        AppLog::create([
            'user' => $user->lname . ', ' . $user->lname . ' ' . $user->mname,
            'activity' => 'Password was changed.',
            'role' => $user->role
        ]);

        return response()->json([
            'status' => 'changed'
        ],200);


    }


    public function updateProfile(Request $req){
        $req->validate([
            'lname' => ['required'],
            'fname' => ['required'],
            'sex' => ['required'],
        ]);
        
        $id = Auth::user()->user_id;

        $user = User::find($id);
        $user->lname = strtoupper($req->lname);
        $user->fname = strtoupper($req->fname);
        $user->mname = strtoupper($req->mname);
        $user->suffix = strtoupper($req->suffix);
        $user->sex = strtoupper($req->sex);
        $user->contact_no = $req->contact_no;

        $user->save();


        AppLog::create([
            'user' => $user->lname . ', ' . $user->lname . ' ' . $user->mname,
            'activity' => 'Updated his profile.',
            'role' => $user->role
        ]);


        return response()->json([
            'status' => 'updated'
        ],200);

    }

}
