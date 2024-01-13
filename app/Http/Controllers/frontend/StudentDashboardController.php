<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Redirect, Response;

class StudentDashboardController extends Controller
{
    //
    public function index()
    {
        return view('frontend.dashboard');
    }
    


}