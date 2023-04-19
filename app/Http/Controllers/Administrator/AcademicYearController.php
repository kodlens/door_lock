<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\DB;
use App\Models\AppLog;

class AcademicYearController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.academic-year');
    }

    public function show($id){
        return AcademicYear::find($id);
    }

    public function getAcademicYears(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = AcademicYear::where('ay_code', 'like', $req->code . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function setActive($id){
        DB::statement('UPDATE academic_years SET active = 0');
        DB::statement('UPDATE academic_years SET active = 1 WHERE ay_id = ?', [$id]);

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function store(Request $req){
        
        $req->validate([
            'ay_code' => ['required', 'unique:academic_years'],
            'ay_desc' => ['required'],
            'semester' => ['required'],

        ]);
        AcademicYear::create([
            'ay_code' => $req->ay_code,
            'ay_desc' => $req->ay_desc,
            'semester' => $req->semester,

        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function update(Request $req, $id){
        
        $req->validate([
            'ay_code' => ['required', 'unique:academic_years,ay_code,' . $id . ',ay_id'],
            'ay_desc' => ['required'],
            'semester' => ['required'],

        ]);

        AcademicYear::where('ay_id', $id)
            ->update([
                'ay_code' => $req->ay_code,
                'ay_desc' => $req->ay_desc,
                'semester' => $req->semester,
            ]);

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){
        AcademicYear::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }


}
