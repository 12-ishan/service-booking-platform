<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response;
use App\User;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function home(){

        $data["pageTitle"] = 'Dashboard';
        $data["activeMenu"] = 'dashboard';
        return view('admin.dashboard')->with($data);

    }

    public function permissionDenied(){

        $data["pageTitle"] = 'Permission Denied';
        //$data["activeMenu"] = 'dashboard';
        return view('admin.permissionDenied')->with($data);

    }

}
