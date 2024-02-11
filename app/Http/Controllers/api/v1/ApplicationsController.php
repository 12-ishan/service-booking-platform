<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Frontend\ApplicantDetails;

use App\Models\Frontend\ParentDetails;
use App\Models\Frontend\Academics;
use App\Models\Frontend\AwardsRecognition;
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

    public function storeApplicantParent(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $checkParent = ParentDetails::where('application_id', $request->application_id)->first();

       if(empty($checkParent))
       {
           $applicantParent = new ParentDetails();
           $editStatus = 0;
       }
       else
       {
        $applicantParent = ParentDetails::find($checkParent->id);
            
        $editStatus = 1;
           
       }
           $applicantParent->application_id = $request->input('application_id');
           $applicantParent->father_salutation = $request->input('father_salutation');
           $applicantParent->father_name = $request->input('father_name');
           $applicantParent->father_mobile = $request->input('father_mobile');
           $applicantParent->father_email = $request->input('father_email');
           $applicantParent->father_is_working =  $request->input('father_is_working');
           $applicantParent->mother_salutation = $request->input('mother_salutation');
           $applicantParent->mother_name = $request->input('mother_name');
           $applicantParent->mother_mobile = $request->input('mother_mobile');
           $applicantParent->mother_email = $request->input('mother_email');
           $applicantParent->mother_is_working =  $request->input('mother_is_working');
           $applicantParent->status = 1;
           $applicantParent->sort_order = 1;
           $applicantParent->increment('sort_order');
           $applicantParent->save();
                  
        if($editStatus == 1){
            $response = [
                'message' => 'parent details updated',
                'status' => 'success'
            ];
        }
        else{
            $response = [
                'message' => 'parent details saved',
                'status' => 'success'
            ];
        }
     }
        return response()->json($response, 201);
    }

    public function getParent(Request $request)
    {
        $parentDetails = ParentDetails::where('application_id', $request->application_id)->first();
       
        if (empty($parentDetails)) {
           $response = [
            'status' => '0',
            'message' => 'no record found'
           ];
        }
        else
        {
            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  $parentDetails
            ];
        } 
        return response()->json($response, 201);
    }

    public function storeAcademics(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $checkAcademics = Academics::where('application_id', $request->application_id)->first();

       if(empty($checkAcademics))
       {
           $academics = new Academics();
           $editStatus = 0;
       }
       else
       {
            $academics = Academics::find($checkAcademics->id);  
            $editStatus = 1;    
       }
           $academics->application_id = $request->input('application_id');
           $academics->ug_college = $request->input('college');
           $academics->ug_university = $request->input('university');
           $academics->ug_degree = $request->input('degree');
           $academics->ug_mode = $request->input('ug_mode');
           $academics->ug_enroll_year =  $request->input('ug_enroll_year');
           $academics->ug_pass_year = $request->input('ug_pass_year');
           $academics->ug_percentage = $request->input('ug_percentage');
           $academics->im_diploma_pursue = $request->input('im_diploma_pursue');
           $academics->im_college = $request->input('im_college');
           $academics->im_board =  $request->input('im_board');
           $academics->im_stream =  $request->input('im_stream'); $academics->im_percentage =  $request->input('im_percentage'); $academics->im_enroll_year =  $request->input('im_enroll_year');
           $academics->im_pass_year =  $request->input('im_pass_year');
           $academics->hg_school =  $request->input('hg_school');
           $academics->hg_board =  $request->input('hg_board');  $academics->hg_percentage =  $request->input('hg_percentage');  $academics->hg_stream =  $request->input('hg_stream');
           $academics->hg_enroll_year =  $request->input('hg_enroll_year');
           $academics->hg_pass_year =  $request->input('hg_pass_year');
           $academics->status = 1;
           $academics->sort_order = 1;
           $academics->increment('sort_order');
           $academics->save();
                  
        if($editStatus == 1){
            $response = [
                'message' => 'academics details updated',
                'status' => 'success'
            ];
        }
        else{
            $response = [
                'message' => 'academics details saved',
                'status' => 'success'
            ];
        }
     }
        return response()->json($response, 201);
    }

    public function getAcademics(Request $request)
    {
        $academics = Academics::where('application_id', $request->application_id)->first();
       
        if (empty($academics)) {
           $response = [
            'status' => '0',
            'message' => 'no record found'
           ];
        }
        else
        {
            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  $academics
            ];
        } 
        return response()->json($response, 201);
    }

    public function storeAwardsRecognition(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $checkAr = AwardsRecognition::where('application_id', $request->application_id)->first();

       if(empty($checkAr))
       {
           $awardRecognition = new AwardsRecognition();
           $editStatus = 0;
       }
       else
       {
            $awardRecognition = AwardsRecognition::find($checkAr->id);  
            $editStatus = 1;    
       }
           $awardRecognition->application_id = $request->input('application_id');
           $awardRecognition->ar_name = $request->input('ar_name');
           $awardRecognition->ar_first = $request->input('ar_first');
           $awardRecognition->ar_level_first = $request->input('level_first');
           $awardRecognition->ar_fr_year = $request->input('yearFirst');
           $awardRecognition->ar_second =  $request->input('ar_second');
           $awardRecognition->ar_level_second = $request->input('level_second');
           $awardRecognition->ar_sr_year = $request->input('yearScond');
           $awardRecognition->lp_lang1 = $request->input('lp_lang1');
           $awardRecognition->lp_lang2 = $request->input('lp_lang2');
           $awardRecognition->lp_p_lang1 =  $request->input('proficiency_lang1');
           $awardRecognition->lp_p_lang2 =  $request->input('proficiency_lang2'); $awardRecognition->ho_hobby1 =  $request->input('ho_hobby1'); $awardRecognition->ho_hobby2 =  $request->input('ho_hobby2');
           $awardRecognition->ho_hobby3 =  $request->input('ho_hobby3');
           $awardRecognition->ho_hobby4 =  $request->input('ho_hobby4');
           $awardRecognition->status = 1;
           $awardRecognition->sort_order = 1;
           $awardRecognition->increment('sort_order');
           $awardRecognition->save();
                  
        if($editStatus == 1){
            $response = [
                'message' => 'awards and recognition details updated',
                'status' => 'success'
            ];
        }
        else{
            $response = [
                'message' => 'awards and recognition details saved',
                'status' => 'success'
            ];
        }
     }
        return response()->json($response, 201);
    }

    public function getAwardsRecognition(Request $request)
    {
        $awardRecognition = AwardsRecognition::where('application_id', $request->application_id)->first();
       
        if (empty($awardRecognition)) {
           $response = [
            'status' => '0',
            'message' => 'no record found'
           ];
        }
        else
        {
            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  $awardRecognition
            ];
        } 
        return response()->json($response, 201);
    }
}
