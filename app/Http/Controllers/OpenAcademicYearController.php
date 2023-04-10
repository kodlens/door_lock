<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;

class OpenAcademicYearController extends Controller
{
    //

    public function getOpenAcademicYear(){

        return AcademicYear::orderBy('ay_id', 'desc')
            ->get();
    }
}
