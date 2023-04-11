<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicYear;
use App\Models\User;
use App\Models\AppLog;

class RFIDApiController extends Controller
{
    //

    public function validateRFID(Request $req){
        //return $req;
        $rfid = $req->rfid;

        $ay = AcademicYear::where('active', 1)->first();

        $user = User::where('rfid', $rfid)->first();
        $isMasterCard  = $user->card_type == 'MASTER CARD' ? 1 : 0; //check if it is master card

        if($isMasterCard > 0){
            //if it is master card always return true
            return 1;
        }

        $timeNow = date('H:i');
        $day = date('D');

        $data = DB::table('schedules as a')
            ->join('users as b', 'a.user_id', 'b.user_id')
            ->join('doors as c', 'a.door_id', 'c.door_id')
            ->where('a.time_start', '<=', $timeNow)
            ->where('a.time_end', '>', $timeNow)
            ->where('b.rfid', $rfid)
            ->where('c.mac_add', $req->doormac)
            ->where('a.ay_id', $ay->ay_id)
            ->where($day, 1);

        //return $data;
        $name = $user->lname . ', ' . $user->lname . ' ' . $user->mname;

        if($data->count() > 0){

            AppLog::create([
                'user' => $name,
                'activity' => $rfid . ' of ' . $name . ' was swiped and accepted. Door is unlock.'
            ]);

            return 1;
        }else{

            AppLog::create([
                'user' => $name,
                'activity' => $rfid . ' of ' . $name . ' was swiped and rejected.'
            ]);

            return 0;
        }
    }
}
