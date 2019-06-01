<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

 
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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('guest')->except('logout');
        // $this->middleware('auth')->except('logout');

    }

    /**
     * @Get("/login", as="login")
     * 
     *
     * Login api
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
         // $this->middleware('auth');

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            
            $user = Auth::user();


            // dd($user->toArray());

            // \Session::put("user", $user->toArray());
            // \Session::save();

            // dd(session());

            // Auth::login($user, true); //remember the user.

            // $success['token'] = $user->createToken('MyApp')->accessToken;

            $request->session()->regenerate();
            // session()->save();

            // \Session::start();
            // \Session::invalidate();
            // dd(\Session::all());

            // $request->setLaravelSession(session());


            // dd(\Session::all());

            $success = array(

                "message"=>"You have succeeded"
            );

            return response()->json(['success' => $success], 200);
        } 
        else {
            
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
    * @Get("/user")
    *
    */
    public function is_authd(Request $request){

        // dd(\Session::all());

        // dd(session());

        // dd(Auth::check());   

        if(Auth::check()){

            $user = Auth::user();

            return response()->json(array("email"=>$user->email));
        }
        else{

            return response()->json(array("email"=>"None"));
        }
    }

    /**
     * @Get("/logout")
     * 
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // $this->guard()->logout();

        $request->session()->invalidate();

        // return $this->loggedOut($request) ?: redirect('/');
    }
}
// 