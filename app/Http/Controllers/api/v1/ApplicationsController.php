<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Frontend\ApplicantDetails;

use Illuminate\Http\Request;
use Validator;

class ApplicationsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(function ($request, $next) {
           // $this->userId = Auth::user()->id;
           // $this->organisationId = Auth::user()->organisationId;
            $this->organisationId = 1;
        
            return $next($request);
        });
    }

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
        if(empty($checkApplication))
        {
            $response = [
                'message' => 'application not exists',
                'status' => '0',
            ];
        }
        else{

        $checkApplicant = ApplicantDetails::where('application_id', $request->application_id)->first();

       if(empty($checkApplicant))
       {
           $applicant = new ApplicantDetails();
           $editStatus = 0;
       }
       else
       {
        $applicant = ApplicantDetails::find($checkApplicant->id);
            
        $editStatus = 1;
           
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
                  
        if($editStatus == 1){
            $response = [
                'message' => 'personal details updated',
                'status' => 'success'
            ];
        }
        else{
            $response = [
                'message' => 'personal details saved',
                'status' => 'success'
            ];
        }
     }
        return response()->json($response, 201);
    }

    public function getApplicant(Request $request)
    {
        $applicantDetails = ApplicantDetails::where('application_id', $request->application_id)->first();
    
        if (empty($applicantDetails)) {
           $response = [
            'status' => '0',
            'message' => 'no record found'
           ];
        }
        else
        {

            $applicantDetailsFrontend = $this->getModifiedaApplicantDetails($applicantDetails->toArray());

            $finalStepsOrder = getSetting("steps_order");
           
            //checking step status
            $stepWithStaus = $this->checkStepStatus($finalStepsOrder, $request->application_id);

            $percentage = $this->calculateStatusPercentage($stepWithStaus);

            //fetching next and prev steps
            $currentStep = "applicant_details";
            $currentIndex = array_search($currentStep, $finalStepsOrder);
           
            $nextIndex = $currentIndex + 1;
            $prevIndex = $currentIndex - 1;

            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  [
                    'fields' => $applicantDetailsFrontend,
                    'steps' => $stepWithStaus,
                    'nextStep' => isset($finalStepsOrder[$nextIndex]) ? $finalStepsOrder[$nextIndex] : -1,
                    'prevStep' => isset($finalStepsOrder[$prevIndex]) ? $finalStepsOrder[$prevIndex]  : -1,
                    'completePercentage' => $percentage
                    
                ]
            ];
        } 
        return response()->json($response, 201);
    }

    protected function getModifiedaApplicantDetails($array){

        $modifiedArray = [
            'id' => $array['id'],
            'application_id' => $array['application_id'],
            'first_name' => $array['pd_first_name'],
            'last_name' => $array['pd_last_name'],
            'status' => $array['status'],
            'sort_order' => $array['sort_order'],
        ];
    
        // Remove unwanted fields
        unset($modifiedArray['created_at']);
        unset($modifiedArray['updated_at']);
        unset($modifiedArray['sort_order']);
    
        // $modifiedArray now contains the modified array without created_at and updated_at
        return $modifiedArray;

    }

    protected function checkStepStatus($step, $applicationId){

        $updatedStatusArray = [];

        $i=0;
        foreach($step as $value){

            $status = $this->getStatusForStage($value, $applicationId);
           
            $updatedStatusArray[$i]['label'] = $value;
            $updatedStatusArray[$i]['status'] = $status;

            $i++;

        }
        return $updatedStatusArray;

    }

    protected function getStatusForStage($stage, $applicationId)
    {
        switch ($stage) {

            case 'applicant_details':
                return ApplicantDetails::where('application_id', $applicationId)->where('status', 1)->exists() ? 1 : 0;
                

            // Add cases for other stages if needed

            default:
                return 0; // Default to false if the stage is not found
        }
    }

    protected function calculateStatusPercentage($steps)
    {
        $totalIterations = count($steps);
        $status1Iterations = collect($steps)->where('status', 1)->count();

        if ($totalIterations === 0) {
            return 0; // Avoid division by zero
        }

        $percentage = round(($status1Iterations / $totalIterations) * 100, 2);

        return $percentage;
    }

}
