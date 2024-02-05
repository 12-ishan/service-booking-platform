<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;


class StudentController extends Controller
{
    //
    public function studentRegister(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:student,email',
            'password' => 'required|min:8'
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
        }
    
        // Proceed with registration if validation passes
        $checkStudent = Student::where('email', $request->email)->first();
    
        if (empty($checkStudent)) {
            $student = new Student();
    
            $password = $request->input('password');
    
            $student->first_name = $request->input('first_name');
            $student->last_name = $request->input('last_name');
            $student->email = $request->input('email');
            $student->password = Hash::make($password);
            $student->status = 1;
            $student->sort_order = 1;
            $student->increment('sort_order');
            $student->save();
    
            $token = $student->createToken($request->email)->plainTextToken;
    
            $response = [
                'message' => 'Registered successfully',
                'status' => 'success',
                'student' => $student->id,
                'token' => $token
            ];
        } else {
            $response = [
                'message' => 'Email already exists',
                'status' => 'failed'
            ];
        }
    
        return response()->json($response, 201);
    }
    
}


   
   

