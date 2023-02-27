<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Door;


class DoorController extends Controller
{
    //


    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        return view('administrator.door');
    }

    public function getDoors(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Door::where('door_name', 'like', $req->door . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function show($id){
        return Door::find($id);
    }



    public function store(Request $req){
        $req->validate([
            'door_name' => ['required', 'unique:doors'],
        ]);

        Door::create([
            'door_name' => strtoupper($req->door_name)
        ]);

        return response()->json([
            'status' => 'saved'
        ],200);
    }

    public function update(Request $req, $id){

        $validate = $req->validate([
            'door_name' => ['required', 'string', 'unique:doors,door_name,' .$id .',door_id'],
        ]);


        $data = Door::find($id);
        $data->door_name = $req->door_name;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ],200);
    }

    public function destroy($id){
        Door::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ],200);
    }
}
