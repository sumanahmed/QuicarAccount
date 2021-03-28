<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    /**
     * login method
     */
    public function login () 
    {
        return view ("auth.login");
    }

    /**
     * signin method
     */
    public function signIn (Request $request) 
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if($user != null){
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                $user = Auth::user();
                return redirect()->route('dashboard')->with('message','Successfully logged in !');
            }else{
                return redirect()->route('login')->with('error_message','Email/Password is wrong !');
            }
        }else{
            return redirect()->route('login')->with('error_message','You are not admin');;
        }
    }

    // backend admin log out
    public function logout(Request $request)
    {
        if(Auth::check()){
            Auth::logout();
        }
        return redirect()->route('login');
    }
}
