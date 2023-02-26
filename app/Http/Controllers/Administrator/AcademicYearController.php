<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;

class AcademicYearController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.academic-year');
    }

    public function getAcademicYears(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = AcademicYear::where('ay_code', 'like', $req->code . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function store(Request $req){
        
        $req->validate([
            'ay_code' => ['required', 'unique:academic_years'],
            'ay_desc' => ['required']
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


}
