<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Redirect, Response;

class StudentController extends Controller
{
    //
    public function index()
    {
        return view('frontend.login');
    }
    

    public function doStudentLogin(Request $request){
     
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required',
            ]);
     
            $credentials = $request->only('email', 'password');

            if (Auth::guard('student')->attempt($credentials)) {
                $user = Auth::guard('student')->user();
            
                if ($user->status == 1) {
                    return redirect()->intended('student/dashboard');
                    
                }else{

                    Auth::guard('student')->logout(); 
                   
                    return redirect()->route('studentLogin')->with('message', 'Invalid Access');
                    
                }

                // Authentication passed...
                
            }
            return Redirect::to("login")->with('message', 'Oppes! You have entered invalid credentials');
    }

    public function logout()
    {
        Auth::guard('student')->logout(); 
        return Redirect::to("login")->with('message', 'Logged out successfully');
    }

}