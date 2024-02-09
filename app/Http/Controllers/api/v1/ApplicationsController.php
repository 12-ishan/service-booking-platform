<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Frontend\ApplicantDetails;
use Illuminate\Http\Request;
use Validator;

class ApplicationsController extends Controller
{
    public function storeApplicant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required',
            'application_id' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
        }

        $checkApplication = Application::where('id', $request->application_id)->first();

       if($checkApplication)
       {
       $checkApplicant = ApplicantDetails::where('application_id', $request->application_id)->first();

       if(empty($checkApplicant))
       {
           $applicant = new ApplicantDetails();
           $response = [
               'message' => 'personal details saved',
               'status' => 'success',
               'applicant' => $applicant->id
           ];
       }
       else
       {
           $applicant = $checkApplicant;
           $response = [
               'message' => 'personal details updated',
               'status' => 'success',
               'applicant' => $applicant->id
           ];
       }

           $applicant->application_id = $request->input('application_id');
           $applicant->pd_first_name = $request->input('first_name');
           $applicant->pd_last_name = $request->input('last_name');
           $applicant->pd_email = $request->input('email');
           $applicant->pd_mobile_number = $request->input('mobile_number');
           $applicant->pd_gender_id =  $request->input('gender');
           $applicant->pd_bg_id = $request->input('blood_group');
           $applicant->pd_dob = $request->input('date_of_birth');
           $applicant->pd_cdate_time = $request->input('current_date_time');
           $applicant->ca_house_number = $request->input('house_number');
           $applicant->ca_city = $request->input('city');
           $applicant->ca_state_id = $request->input('state');
           $applicant->ca_pincode = $request->input('pincode');
           $applicant->is_permanent_address = $request->input('is_permanent_address');
           $applicant->status = 1;
           $applicant->sort_order = 1;
           $applicant->increment('sort_order');
           $applicant->save();
        }
        else{
            $response = [
                'message' => 'no record found',
                'status' => '0'
            ];
        }

        return response()->json($response, 201);
    }

    public function getApplicant(Request $request)
    {
        $applicantDetails = ApplicantDetails::where('id', $request->id)->first();
       
        if (empty($applicantDetails)) {
           $response = [
            'message' => 'no record found',
            'status' => '0'
           ];
        }
        else
        {
            $response = [
                'data' =>  $applicantDetails,
                'status' => '1'
            ];
        } 
        return response()->json($response, 201);
    }
}
