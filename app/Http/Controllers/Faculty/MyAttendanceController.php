<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Models\Schedule;
use Auth;
use App\Models\ScheduleStudentList;
use App\Models\AttendanceStudent;
use Illuminate\Support\Facades\DB;
use App\Models\AppLog;


class MyAttendanceController extends Controller
{
    //

    public function index(){
        return view('faculty.my-attendances');
    }


    public function getAll(Request $req){

        $sort = explode('.', $req->sort_by);

        $user_id = Auth::user()->user_id;
        
        $data = Attendance::with(['ay', 'schedule', 'student_attendance'])
            ->where('user_id', $user_id)
            ->where('ay_id', 'like', $req->ay . '%')
            ->where(function($q) use ($req){
                $q->orWhere('attendance_remark', 'like', $req->remark . '%')
                    ->orWhereNull('attendance_remark');
            })
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }



    public function getStudentList(Request $req){

        $schedId = $req->scheduleid;
        $students = ScheduleStudentList::where('schedule_id', $schedId)
            ->get();

        return $students;
    }

    public function create(){
        $user = Auth::user();
        $ay = AcademicYear::where('active', 1)->first();

        $schedules = Schedule::where('user_id', $user->user_id)
            ->get();

        return view('faculty.my-attendance-create')
            ->with('ay', $ay)
            ->with('schedules', $schedules)
            ->with('attendance', '')
            ->with('isUpdate', 0);
    }

    public function store(Request $req){
        //return $req;

        $ndate = date('Y-m-d', strtotime($req->attendance_date));
        $user = Auth::user();
        $userId = $user->user_id;
        $ay = AcademicYear::where('active', 1)->first();

        //query if date already have data in databsae
        $isExist = Attendance::where('attendance_date', $ndate)
            ->where('user_id', $userId)
            ->where('schedule_id', $req->schedule_id)
            ->where('ay_id', $ay->ay_id)
            ->exists();

        //validate if already have attendance recorded in a date.
        //return 422 if already existed in database
        if($isExist){
            return response()->json([
                'errors' => [
                    'duplicate_attendance' => 'Attendance for this day already recorded.'
                ]
            ], 422);
        }

 
        //transaction, inserting data to database
        DB::transaction(function() use ($req, $ndate, $userId, $ay) {
            //
            $att = Attendance::create([
                'user_id' => $userId,
                'ay_id' => $ay->ay_id,
                'schedule_id' => $req->schedule_id,
                'attendance_date' => $ndate,
                'attendance_remark' => $req->attendance_remark
            ]);

            $data = [];


            //its n2
            //need to optimized if possible
            foreach($req->students as $std){
                
                //closure
                $isPresent = function() use ($req, $std){
                    //helped by chatGPT
                    $flag = 0;
                    foreach($req->checkedRows as $check){
                        if($check['schedule_student_list_id'] == $std['schedule_student_list_id']){
                            $flag = 1;
                            break;
                        }
                    }
                    return $flag;
                };

                array_push($data, 
                [
                    'attendance_id' => $att->attendance_id,
                    'student_id' => $std['student_id'],
                    'student_lname' => $std['student_lname'],
                    'student_fname' => $std['student_fname'],
                    'student_mname' => $std['student_mname'],
                    'student_suffix' => $std['student_suffix'],
                    'student_sex' => $std['student_sex'],
                    'student_contact_no' => $std['student_contact_no'],
                    'is_present' => $isPresent(),
                ]);
            }

            AttendanceStudent::insert($data);
           
        });

        AppLog::create([
            'user' => $user->lname . ', ' . $user->lname . ' ' . $user->mname,
            'activity' => 'Saved student attendance.',
            'role' => $user->role
        ]);


        return response()->json([
            'status' => 'saved'
        ], 200);
        
    }




    //update here
    public function edit($id){

        $user = Auth::user();
        $ay = AcademicYear::where('active', 1)->first();
        $schedules = Schedule::where('user_id', $user->user_id)
            ->get();
        $attendance = Attendance::with('student_attendance')->find($id);


        return view('faculty.my-attendance-create')
            ->with('ay', $ay)
            ->with('schedules', $schedules)
            ->with('attendance', $attendance)
            ->with('isUpdate', 1);
    }

    public function update(Request $req, $id){
        //return $req;

        $ndate = date('Y-m-d', strtotime($req->attendance_date));
        $userId = Auth::user()->user_id;
        $ay = AcademicYear::where('active', 1)->first();

        //query if date already have data in databsae
        $isExist = Attendance::where('attendance_date', $ndate)
            ->where('user_id', $userId)
            ->where('schedule_id', $req->schedule_id)
            ->where('ay_id', $ay->ay_id)
            ->where('attendance_id', '!=', $id)
            ->exists();

        //validate if already have attendance recorded in a date.
        //return 422 if already existed in database
        if($isExist){
            return response()->json([
                'errors' => [
                    'duplicate_attendance' => 'Attendance for this day already recorded.'
                ]
            ], 422);
        }

        $att = Attendance::where('attendance_id', $id)
            ->update([
                'schedule_id' => $req->schedule_id,
                'attendance_date' => $ndate,
                'attendance_remark' => $req->attendance_remark
            ]);
        
        $data = [];
        $ids = [];

        foreach($req->students as $std){
            
            //closure
            $isPresent = function() use ($req, $std){
                //helped by chatGPT
                $flag = 0;
                foreach($req->checkedRows as $check){
                    if($check['attendance_student_id'] == $std['attendance_student_id']){
                        $flag = 1;
                        break;
                    }
                }
                return $flag;
            };

            AttendanceStudent::where('attendance_student_id', $std['attendance_student_id'])
                ->update([
                    'student_id' => $std['student_id'],
                    'student_lname' => $std['student_lname'],
                    'student_fname' => $std['student_fname'],
                    'student_mname' => $std['student_mname'],
                    'student_suffix' => $std['student_suffix'],
                    'student_sex' => $std['student_sex'],
                    'student_contact_no' => $std['student_contact_no'],
                    'is_present' => $isPresent(),
                ]);
        }

        return response()->json([
            'status' => 'updated'
        ], 200);

    }


    




    
    public function printAttendance($id){

        $user = Auth::user();
        $ay = AcademicYear::where('active', 1)->first();
        $schedules = Schedule::where('user_id', $user->user_id)
            ->get();
        $attendance = Attendance::with(['student_attendance', 'schedule', 'ay'])->find($id);

        //return $attendance;

        return view('faculty.print-attendance')
            ->with('attendance', $attendance);
    }
    //delete attendance
    public function destroy($id){

        Attendance::destroy($id);

        AppLog::create([
            'user' => $user->lname . ', ' . $user->lname . ' ' . $user->mname,
            'activity' => 'Deleted the attendance.',
            'role' => $user->role
        ]);
        return response()->json([
            'status' => 'deleted'
        ], 200);
    }









    //Fetch data attendance of the faculty from database
    public function generateMyAttendance(Request $req){
        $user = Auth::user();
        $ay = AcademicYear::where('active', 1)->first();

        //convert date from javascript to UNIX Time and convert format Y-m-d
        $dStart = date('Y-m-d', strtotime($req->start_date));
        $dEnd = date('Y-m-d', strtotime($req->end_date));
        
        $schedules = Schedule::where('user_id', $user->user_id)
            ->where('ay_id', $ay->ay_id)
            ->orderBy('time_start', 'asc')
            ->get();
        //
        $attendances = DB::table('schedules as a')
            ->join('faculty_attendances as b', 'a.schedule_id', 'b.schedule_id')
            ->join('academic_years as c', 'a.ay_id', 'c.ay_id')
            ->join('doors as d', 'a.door_id', 'd.door_id')
            ->where('a.user_id', $user->user_id)
            ->whereBetween('b.attendance_date', [$dStart, $dEnd])
            ->orderBy('b.attendance_date', 'ASC')
            ->orderBy('a.time_start', 'ASC')

            ->get();

       // return $schedules;

        return view('faculty.generate-my-attendance')
            ->with('schedules', $schedules)
            ->with('attendances', $attendances)
            ->with('start_date',$dStart)
            ->with('end_date', $dEnd);
        
    }

}
