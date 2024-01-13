<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    //
    public function index(){

        return view('frontend.registration');
    }

    public function insert(Request $request){

        $this->validate(request(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
            
        ]);

        $student = new Student();

        $password = $request->input('password');

        $student->first_name = $request->input('firstName');
        $student->last_name = $request->input('lastName');
        $student->email = $request->input('email');
        $student->password = Hash::make($password);
        $student->status = 1;
        $student->sort_order = 1;
        $student->increment('sort_order');
        $student->save();
        return redirect()->route('studentRegistration')->with('message', 'Registered');
    }
    }

