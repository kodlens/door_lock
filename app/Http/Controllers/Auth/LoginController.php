<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AppLog;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('auth.login-custom');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            AppLog::create([
                'user' => $user->lname . ', ' . $user->lname . ' ' . $user->mname,
                'activity' => 'Login to the system.',
                'role' => $user->role
            ]);

            return $user;
            // return redirect()->intended('dashboard');
        }

        return response()->json([
            'errors' => [
                'username' => ['Username and password error. Access denied.']
            ]
        ], 422);
    }

    public function logout(Request $req){
        $user = Auth::user();
        AppLog::create([
            'user' => $user->lname . ', ' . $user->lname . ' ' . $user->mname,
            'activity' => 'Logout to the system.',
            'role' => $user->role
        ]);


        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
       
        return redirect('/');
    }

}
