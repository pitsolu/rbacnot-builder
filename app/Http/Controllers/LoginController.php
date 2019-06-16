<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    /**
     * @Get("/login", as="login")
     *
     * Login api
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            
            $user = Auth::user();

            $request->session()->regenerate();

            $response = array(

                "success" => true,
                "message"=>"Logged in successfully."
            );

            return response()->json($response, 200);
        } 
        else {

            $response = array(

                "success" => false,
                "message"=>"Failed to login!"
            );
            
            return response()->json($response, 401);
        }
    }

    /**
    * @Get("/user")
    *
    */
    public function is_authd(Request $request){

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