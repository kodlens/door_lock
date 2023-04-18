<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Models\Appointment;
use App\Models\User;
use App\Models\DentistSchedule;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->middleware('guest');





Auth::routes([
    'login' => 'false'
]);

Route::get('/load-user', function(){
    if(Auth::check()){
        return Auth::user();
    }
});




Route::post('/cpanel/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/sample',[App\Http\Controllers\SampleController::class,'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sign-up', [App\Http\Controllers\SignUpController::class, 'index']);
Route::post('/sign-up', [App\Http\Controllers\SignUpController::class, 'store']);



//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);
Route::get('/load-semesters', [App\Http\Controllers\AddressController::class, 'loadSemesters']);



//ADMINISTRATOR

Route::middleware(['auth'])->group(function() {

    Route::resource('/cpanel/home', App\Http\Controllers\Administrator\AdminHomeController::class);

    Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
    Route::get('/get-users',[App\Http\Controllers\Administrator\UserController::class, 'getUsers']);


    Route::resource('/faculty', App\Http\Controllers\Administrator\FacultyController::class);
    Route::get('/get-faculty',[App\Http\Controllers\Administrator\FacultyController::class, 'getFaculty']);


    Route::resource('/admin-home', App\Http\Controllers\Administrator\AdminHomeController::class);

    Route::resource('/doors', App\Http\Controllers\Administrator\DoorController::class);
    Route::get('/get-doors', [App\Http\Controllers\Administrator\DoorController::class, 'getDoors']);



    Route::resource('/schedules', App\Http\Controllers\Administrator\ScheduleController::class);
    Route::get('/get-schedules',[App\Http\Controllers\Administrator\ScheduleController::class, 'getSchedules']);
    Route::get('/get-browse-users',[App\Http\Controllers\Administrator\ScheduleController::class, 'getBrowseUsers']);
    Route::get('/get-browse-doors',[App\Http\Controllers\Administrator\ScheduleController::class, 'getBrowseDoors']);


    Route::resource('/academic-years', App\Http\Controllers\Administrator\AcademicYearController::class);
    Route::get('/get-academic-years', [App\Http\Controllers\Administrator\AcademicYearController::class, 'getAcademicYears']);
    Route::post('/set-active-ay/{ayId}', [App\Http\Controllers\Administrator\AcademicYearController::class, 'setActive']);

    

    Route::resource('/logs', App\Http\Controllers\Administrator\AppLogController::class);
    Route::get('/get-logs', [App\Http\Controllers\Administrator\AppLogController::class, 'getLogs']);





}); //ADMINISTRATOR


//Open AcadYear
Route::get('/get-open-academic-years', [App\Http\Controllers\OpenAcademicYearController::class, 'getOpenAcademicYear']);



Route::middleware(['auth', 'faculty'])->group(function() {

    Route::resource('/faculty-home', 
        App\Http\Controllers\Faculty\FacultyHomeController::class);
    
    Route::resource('/my-schedules', App\Http\Controllers\Faculty\MyScheduleController::class);
    Route::get('/get-my-schedules', [App\Http\Controllers\Faculty\MyScheduleController::class, 'getAll']);
        

    Route::get('/my-schedule-student-list/{schedule_id}', [App\Http\Controllers\Faculty\MyScheduleStudentListController::class, 'index']);
    Route::post('/my-schedule-student-list', [App\Http\Controllers\Faculty\MyScheduleStudentListController::class, 'store']);
    Route::put('/my-schedule-student-list-update/{schedule_student_list_id}', [App\Http\Controllers\Faculty\MyScheduleStudentListController::class, 'update']);
    Route::get('/my-schedule-student-list-edit/{schedule_student_list_id}', [App\Http\Controllers\Faculty\MyScheduleStudentListController::class, 'show']);
    Route::delete('/my-schedule-student-list-delete/{schedule_student_list_id}', [App\Http\Controllers\Faculty\MyScheduleStudentListController::class, 'destroy']);

    
    Route::get('/get-my-schedule-student-list', [App\Http\Controllers\Faculty\MyScheduleStudentListController::class, 'getAll']);

    Route::resource('/my-students', App\Http\Controllers\Faculty\MyStudentController::class);
    Route::get('/get-faculty-students', [App\Http\Controllers\Faculty\MyStudentController::class, 'getAll']);

    Route::resource('/my-attendances', App\Http\Controllers\Faculty\MyAttendanceController::class);
    Route::get('/get-my-attendances', [App\Http\Controllers\Faculty\MyAttendanceController::class, 'getAll']);
    Route::get('/get-my-attendance-student-list', [App\Http\Controllers\Faculty\MyAttendanceController::class, 'getStudentList']); //get the list of student in attendance
    Route::get('/print-attendance/{attId}', [App\Http\Controllers\Faculty\MyAttendanceController::class, 'printAttendance']);


    Route::resource('/my-profile', App\Http\Controllers\Faculty\MyProfileController::class);
    Route::post('/reset-my-password', [App\Http\Controllers\Faculty\MyProfileController::class, 'resetPassword']);
    Route::post('/update-my-profile', [App\Http\Controllers\Faculty\MyProfileController::class, 'updateProfile']);


    Route::get('/my-schedule-student-attendance/{sId}', [App\Http\Controllers\Faculty\MyScheduleStudentAttendanceController::class, 'index']);
    Route::get('/get-my-schedule-student-list-for-attendance', [App\Http\Controllers\Faculty\MyScheduleStudentAttendanceController::class, 'getAll']);

    //Route::get('/get-attendances', [App\Http\Controllers\Faculty\AttendanceController::class, 'getAll']);


}); //FACULTY



Route::get('/rfid', [App\Http\Controllers\RFIDApiController::class, 'validateRFID']);


Route::get('/session', function(){
    return Session::all();
});





Route::get('/collect', function(){
    return $collection = collect([1, 2, 3]);
});


Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();


});
