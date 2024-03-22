<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationVerifyController extends Controller
{
    public function verify(Request $request)
    {

        $this->middleware('auth');
        $studentId = Auth::user()->id;

        $application = Application::find($request->application_id);

        if($application){

            $response = [
                'message' => 'application found',
                'status' => '1'
            ];
        }
        else{
            $response = [
                'message' => 'application not found',
                'status' => '0'
            ];

        }
        return response()->json($response, 201);
    }
}
