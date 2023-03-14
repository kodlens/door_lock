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
});





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
    Route::get('/get-browse-faculty',[App\Http\Controllers\Administrator\ScheduleController::class, 'getBrowseFaculty']);
    Route::get('/get-browse-doors',[App\Http\Controllers\Administrator\ScheduleController::class, 'getBrowseDoors']);


    Route::resource('/academic-years', App\Http\Controllers\Administrator\AcademicYearController::class);
    Route::get('/get-academic-years', [App\Http\Controllers\Administrator\AcademicYearController::class, 'getAcademicYears']);


}); //ADMINISTRATOR




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
