<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicYear;
use App\Models\User;
use App\Models\AppLog;

use App\Models\Door;
use App\Models\FacultyAttendance;


class RFIDApiController extends Controller
{
    //

    public function validateRFID(Request $req){
        // URL -> /rfid?rfid=abcd123&doormac=48:55:19:C8:C2:B8
        //return $req;
        $rfid = $req->rfid;

        $ay = AcademicYear::where('active', 1)->first();

        $user = User::where('rfid', $rfid)->first();

        if($user){
            $isMasterCard  = $user->card_type == 'MASTER CARD' ? 1 : 0; //check if it is master card
            if($isMasterCard > 0){
                //if it is master card always return true

                AppLog::create([
                    'user' => $user->lname . ', '.  $user->fname,
                    'activity' => 'Master card was swiped ('. $rfid . '). Door is unlock.',
                    'role' => $user->role,
                    'door_id' => 0,
                    'door' => '',
                    'schedule_id' => 0,
                    'log_type' => 'MASTER CARD'
                ]);

                return 1;
            }
        }

        $timeNow = date('H:i');
        $today = date('Y-m-d');
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
        $count = $data->count();

        //check if $data is not empty
        if($count > 0){

            $data = $data->first();

            //get door description
            $doorDesc = $data->door_name . ' MAC(' . $data->mac_add . ')';

            //get user;
            $name = $user->lname . ', ' . $user->fname . ' ' . $user->mname;


            //record the logs, if successfully found,
            AppLog::create([
                'user' => $name,
                'activity' => $rfid . ' of ' . $name . ' was swiped and accepted. Door is unlock.',
                'role' => $user->role,
                'door_id' => $data->door_id,
                'door' => $doorDesc,
                'schedule_id' => $data->schedule_id,
                'log_type' => 'ATTENDANCE'
            ]);


            $attendanceExist =  FacultyAttendance::where('attendance_date', $today)
                ->where('schedule_id', $data->schedule_id)
                ->where('user_id', $data->user_id)
                ->where('door_id', $data->door_id)
                ->exists();

                

            //check if it is already recorded, 1 attendance per day is recorded.
            if(!$attendanceExist){
                //insert attendance if schedule was found and faculty is allowed to enter the room
                FacultyAttendance::create([
                    'user_id' => $data->user_id,
                    'user_name' => $name,
                    'rfid' => $rfid,
                    'role' => $user->role,
                    'door_id' => $data->door_id,
                    'schedule_id' => $data->schedule_id,
                    'attendance_date' => $today,
                    'log_type' => 'ATTENDANCE'
                ]);
            }

            return 1;

        } //if $ata variable is not empty 
        else{ 
            $doorDesc = 'DOOR MAC(' . $req->doormac . ')';
            //record the logs, this is for rejected rfid, not found on the system / not register
            AppLog::create([
                'user' => '',
                'activity' => $rfid . ' was swiped and rejected.',
                'role' => '',
                'door' => $doorDesc,
                'log_type' => 'SWIPE'
            ]);

            return 0;
        }
    }


}
