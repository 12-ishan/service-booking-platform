<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Frontend\ApplicantDetails;

use App\Models\Frontend\ParentDetails;
use App\Models\Frontend\Academics;
use App\Models\Frontend\AwardsRecognition;
use App\Models\Frontend\Scholarship;
use App\Models\Frontend\Documents;
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
           $applicant->pd_profile_id = $request->input('profile_upload');
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
            $applicantDetailsFrontend = '';

            if(!empty($applicantDetails)){
            $applicantDetailsFrontend = $this->getModifiedaApplicantDetails($applicantDetails->toArray());
            }
                       
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
            'applicationId' => $array['application_id'],
            'pdFirstName' => $array['pd_first_name'],
            'pdLastName' => $array['pd_last_name'],
            'pdEmail' => $array['pd_email'],
            'pdMobileNumber' => $array['pd_mobile_number'],
            'pdProfile' => url('/') . "/uploads/applications/" . getMediaName($array['pd_profile_id']),
            'pdGenderId' =>  $array['pd_gender_id'],
            'pdBloodGroupId' =>  $array['pd_bg_id'],
            'pdDob' =>  $array['pd_dob'],
            'pdCurrentDateTime' =>  $array['pd_cdate_time'],
            'caHouseNumber' =>  $array['ca_house_number'],
            'caCity' =>  $array['ca_city'],
            'caStateId' =>  $array['ca_state_id'],
            'caPincode' =>  $array['ca_pincode'],
            'isPermanentAddress' =>  $array['is_permanent_address'],
            'status' => $array['status'],
           
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

            case 'parents_details':
                return ParentDetails::where('application_id', $applicationId)->where('status', 1)->exists() ? 1 : 0;
            
            case 'academics':
                return Academics::where('application_id', $applicationId)->where('status', 1)->exists() ? 1 : 0;
            
            case 'awards':
                return AwardsRecognition::where('application_id', $applicationId)->where('status', 1)->exists() ? 1 : 0;
            
            case 'scholarship':
                return Scholarship::where('application_id', $applicationId)->where('status', 1)->exists() ? 1 : 0;

            case 'documents':
                return Documents::where('application_id', $applicationId)->where('status', 1)->exists() ? 1 : 0;

            case 'preview':
                return 0;

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
            if(!empty($parentDetails)){
                $parentDetailsFrontend = $this->getModifiedParentDetails($parentDetails->toArray());
            }
                       
            $finalStepsOrder = getSetting("steps_order");
           
            //checking step status
            $stepWithStaus = $this->checkStepStatus($finalStepsOrder, $request->application_id);

            $percentage = $this->calculateStatusPercentage($stepWithStaus);

            //fetching next and prev steps
            $currentStep = "parents_details";
            $currentIndex = array_search($currentStep, $finalStepsOrder);
           
            $nextIndex = $currentIndex + 1;
            $prevIndex = $currentIndex - 1;

            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  [
                    'fields' => $parentDetailsFrontend,
                    'steps' => $stepWithStaus,
                    'nextStep' => isset($finalStepsOrder[$nextIndex]) ? $finalStepsOrder[$nextIndex] : -1,
                    'prevStep' => isset($finalStepsOrder[$prevIndex]) ? $finalStepsOrder[$prevIndex]  : -1,
                    'completePercentage' => $percentage
                    
                ]
            ];

        } 
        return response()->json($response, 201);
    }

    protected function getModifiedParentDetails($array){

        $modifiedArray = [
            'id' => $array['id'],
            'applicationId' => $array['application_id'],
            'fatherSalutation' => $array['father_salutation'],
            'fatherName' => $array['father_name'],
            'fatherMobileNumber' => $array['father_mobile'],
            'FatherEmail' => $array['father_email'],
            'fatherIsWorking' => $array['father_is_working'],
            'motherSalutation' =>  $array['mother_salutation'],
            'motherName' =>  $array['mother_name'],
            'motherMobile' =>  $array['mother_mobile'],
            'motherEmail' =>  $array['mother_email'],
            'motherIsWorking' =>  $array['mother_is_working'],
            'status' => $array['status'],
           
        ];
    
        // Remove unwanted fields
        unset($modifiedArray['created_at']);
        unset($modifiedArray['updated_at']);
        unset($modifiedArray['sort_order']);
    
        // $modifiedArray now contains the modified array without created_at and updated_at
        return $modifiedArray;

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
            $academicsFrontend = '';
            if(!empty($academics)){
            $academicsFrontend = $this->getModifiedAcademics($academics->toArray());
            }
                       
            $finalStepsOrder = getSetting("steps_order");
           
            //checking step status
            $stepWithStaus = $this->checkStepStatus($finalStepsOrder, $request->application_id);

            $percentage = $this->calculateStatusPercentage($stepWithStaus);

            //fetching next and prev steps
            $currentStep = "academics";
            $currentIndex = array_search($currentStep, $finalStepsOrder);
           
            $nextIndex = $currentIndex + 1;
            $prevIndex = $currentIndex - 1;

            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  [
                    'fields' => $academicsFrontend,
                    'steps' => $stepWithStaus,
                    'nextStep' => isset($finalStepsOrder[$nextIndex]) ? $finalStepsOrder[$nextIndex] : -1,
                    'prevStep' => isset($finalStepsOrder[$prevIndex]) ? $finalStepsOrder[$prevIndex]  : -1,
                    'completePercentage' => $percentage
                    
                ]
            ];
        } 
        return response()->json($response, 201);
    }

    protected function getModifiedAcademics($array){

        $modifiedArray = [
            'id' => $array['id'],
            'applicationId' => $array['application_id'],
            'ugCollege' => $array['ug_college'],
            'ugUniversity' => $array['ug_university'],
            'ugDegree' => $array['ug_degree'],
            'ugMode' => $array['ug_mode'],
            'ugEnrollYear' => $array['ug_enroll_year'],
            'ugPassYear' =>  $array['ug_pass_year'],
            'ugPercentage' =>  $array['ug_percentage'],
            'interDiplomaPursue' =>  $array['im_diploma_pursue'],
            'interCollege' =>  $array['im_college'],
            'interBoard' =>  $array['im_board'],
            'interStream' =>  $array['im_stream'],
            'interPercentage' =>  $array['im_percentage'],
            'interEnrollYear' =>  $array['im_enroll_year'],
            'interPassYear' =>  $array['im_pass_year'],
            'hgSchool' =>  $array['hg_school'],
            'hgBoard' => $array['hg_board'],
            'hgPercentage' =>  $array['hg_percentage'],
            'hgStream' =>  $array['hg_stream'],
            'hgEnrollYear' =>  $array['hg_enroll_year'],
            'hgPassYear' =>  $array['hg_pass_year'],
            'status' => $array['status'],
           
        ];
    
        // Remove unwanted fields
        unset($modifiedArray['created_at']);
        unset($modifiedArray['updated_at']);
        unset($modifiedArray['sort_order']);
    
        // $modifiedArray now contains the modified array without created_at and updated_at
        return $modifiedArray;

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
            $awardRecognitionFrontend = '';

            if(!empty($awardRecognition)){
            $awardRecognitionFrontend = $this->getModifiedAwardRecognition($awardRecognition->toArray());
            }

            $finalStepsOrder = getSetting("steps_order");
           
            //checking step status
            $stepWithStaus = $this->checkStepStatus($finalStepsOrder, $request->application_id);

            $percentage = $this->calculateStatusPercentage($stepWithStaus);

            //fetching next and prev steps
            $currentStep = "awards";
            $currentIndex = array_search($currentStep, $finalStepsOrder);
           
            $nextIndex = $currentIndex + 1;
            $prevIndex = $currentIndex - 1;

            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  [
                    'fields' => $awardRecognitionFrontend,
                    'steps' => $stepWithStaus,
                    'nextStep' => isset($finalStepsOrder[$nextIndex]) ? $finalStepsOrder[$nextIndex] : -1,
                    'prevStep' => isset($finalStepsOrder[$prevIndex]) ? $finalStepsOrder[$prevIndex]  : -1,
                    'completePercentage' => $percentage
                    
                ]
            ];
        } 
        return response()->json($response, 201);
    }

    protected function getModifiedAwardRecognition($array){

        $modifiedArray = [
            'id' => $array['id'],
            'applicationId' => $array['application_id'],
            'awardName' => $array['ar_name'],
            'firstAward' => $array['ar_first'],
            'firstLevelAward' => $array['ar_level_first'],
            'receiveYear' => $array['ar_fr_year'],
            'secondAward' => $array['ar_second'],
            'secondLevelAward' =>  $array['ar_level_second'],
            'secondReceiveYear' =>  $array['ar_sr_year'],
            'language1' =>  $array['lp_lang1'],
            'language2' =>  $array['lp_lang2'],
            'language1Proficiency' =>  $array['lp_p_lang1'],
            'language2Proficiency' =>  $array['lp_p_lang2'],
            'hobby1' =>  $array['ho_hobby1'],
            'hobby2' =>  $array['ho_hobby2'],
            'hobby3' =>  $array['ho_hobby3'],
            'hobby4' =>  $array['ho_hobby4'],
            'status' => $array['status'],
           
        ];
    
        // Remove unwanted fields
        unset($modifiedArray['created_at']);
        unset($modifiedArray['updated_at']);
        unset($modifiedArray['sort_order']);
    
        // $modifiedArray now contains the modified array without created_at and updated_at
        return $modifiedArray;
    }

    public function storeScholarship(Request $request)
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
        else
        {
            $checkScholarship = Scholarship::where('application_id',  $request->application_id)->first();

            if(empty($checkScholarship))
            {
                $scholarship = new Scholarship();
                $editStatus = 0;
            }
            else
            {
                 $scholarship = Scholarship::find($checkScholarship->id);  
                 $editStatus = 1;    
            }
                $scholarship->application_id = $request->input('application_id');
                $scholarship->merit_based_scholarship = $request->input('meritScholarship');
                $scholarship->explanation_document_id = $request->input('document');
                $scholarship->status = 1;
                $scholarship->sort_order = 1;
                $scholarship->increment('sort_order');
                $scholarship->save();
                       
             if($editStatus == 1){
                 $response = [
                    'message' => 'scholarship details updated',
                    'status' => 'success'
                ];
            }
             else{
                 $response = [
                    'message' => 'scholarship details saved',
                    'status' => 'success'
                ];
            }
        }
            return response()->json($response, 201);
    }

    public function getScholarship(Request $request)
    {
        $scholarship = Scholarship::where('application_id', $request->application_id)->first();
       
        if (empty($scholarship)) {
           $response = [
            'status' => '0',
            'message' => 'no record found'
           ];
        }
        else
        {
            $scholarshipFrontend = '';

            if(!empty($scholarship)){
            $scholarshipFrontend = $this->getModifiedScholarship($scholarship->toArray());
            }
        
            $finalStepsOrder = getSetting("steps_order");
           
            //checking step status
            $stepWithStaus = $this->checkStepStatus($finalStepsOrder, $request->application_id);

            $percentage = $this->calculateStatusPercentage($stepWithStaus);

            //fetching next and prev steps
            $currentStep = "scholarship";
            $currentIndex = array_search($currentStep, $finalStepsOrder);
           
            $nextIndex = $currentIndex + 1;
            $prevIndex = $currentIndex - 1;

            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  [
                    'fields' => $scholarshipFrontend,
                    'steps' => $stepWithStaus,
                    'nextStep' => isset($finalStepsOrder[$nextIndex]) ? $finalStepsOrder[$nextIndex] : -1,
                    'prevStep' => isset($finalStepsOrder[$prevIndex]) ? $finalStepsOrder[$prevIndex]  : -1,
                    'completePercentage' => $percentage
                    
                ]
            ];
        } 
        return response()->json($response, 201);
    }

    protected function getModifiedScholarship($array){

        $modifiedArray = [
            'id' => $array['id'],
            'applicationId' => $array['application_id'],
            'meritBasedScholarshipId' => $array['merit_based_scholarship'],
            'explanationDocument' => url('/') . "/uploads/applications/" . getMediaName($array['explanation_document_id']),
            'status' => $array['status'],
           
        ];
    
        // Remove unwanted fields
        unset($modifiedArray['created_at']);
        unset($modifiedArray['updated_at']);
        unset($modifiedArray['sort_order']);
    
        // $modifiedArray now contains the modified array without created_at and updated_at
        return $modifiedArray;
    }

    public function storeDocument(Request $request)
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
        else
        {
            $checkDocument = Documents::where('application_id',  $request->application_id)->first();

            if(empty($checkDocument))
            {
                $document = new Documents();
                $editStatus = 0;
            }
            else
            {
                 $document = Documents::find($checkDocument->id);  
                 $editStatus = 1;    
            }
                $document->application_id = $request->input('application_id');
                $document->highschool_markssheet_id = $request->input('highSchoolMarksheet');
                $document->inter_markssheet_id = $request->input('interMarsheet');
                $document->consolidated_marksheet_id = $request->input('consolidatedMarksheetId');
                $document->consolidated_certificate_id = $request->input('consolidatedCertificateId');
                $document->aadhar_card_id = $request->input('aadharCardId');
                $document->signature_id = $request->input('signatureId');
                $document->status = 1;
                $document->sort_order = 1;
                $document->increment('sort_order');
                $document->save();
                       
             if($editStatus == 1){
                 $response = [
                    'message' => 'documents details updated',
                    'status' => 'success'
                ];
            }
             else{
                 $response = [
                    'message' => 'documents details saved',
                    'status' => 'success'
                ];
            }
        }
            return response()->json($response, 201);
    }

    public function getDocument(Request $request)
    {
        $document = Documents::where('application_id', $request->application_id)->first();
       
        if (empty($document)) {
           $response = [
            'status' => '0',
            'message' => 'no record found'
           ];
        }
        else
        {

            $documentFrontend = '';

            if(!empty($document)){
            $documentFrontend = $this->getModifiedDocument($document->toArray());
            }
                       
            $finalStepsOrder = getSetting("steps_order");
           
            //checking step status
            $stepWithStaus = $this->checkStepStatus($finalStepsOrder, $request->application_id);

            $percentage = $this->calculateStatusPercentage($stepWithStaus);

            //fetching next and prev steps
            $currentStep = "documents";
            $currentIndex = array_search($currentStep, $finalStepsOrder);
           
            $nextIndex = $currentIndex + 1;
            $prevIndex = $currentIndex - 1;

            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  [
                    'fields' => $documentFrontend,
                    'steps' => $stepWithStaus,
                    'nextStep' => isset($finalStepsOrder[$nextIndex]) ? $finalStepsOrder[$nextIndex] : -1,
                    'prevStep' => isset($finalStepsOrder[$prevIndex]) ? $finalStepsOrder[$prevIndex]  : -1,
                    'completePercentage' => $percentage
                    
                ]
            ];
        } 
        return response()->json($response, 201);
    }

    protected function getModifiedDocument($array){

        $modifiedArray = [
            'id' => $array['id'],
            'applicationId' => $array['application_id'],
            'highschoolMarksheet' => url('/') . "/uploads/applications/" . getMediaName($array['highschool_markssheet_id']),
            'interMarksheet' => url('/') . "/uploads/applications/" . getMediaName($array['inter_markssheet_id']),
            'consolidatedMarksheet' => url('/') . "/uploads/applications/" . getMediaName($array['consolidated_marksheet_id']),
            'consolidatedCertificate' => url('/') . "/uploads/applications/" . getMediaName($array['consolidated_certificate_id']),
            'aadharCard' => url('/') . "/uploads/applications/" . getMediaName($array['aadhar_card_id']),
            'signature' => url('/') . "/uploads/applications/" . getMediaName($array['signature_id']),
            'status' => $array['status'],
           
        ];
    
        // Remove unwanted fields
        unset($modifiedArray['created_at']);
        unset($modifiedArray['updated_at']);
        unset($modifiedArray['sort_order']);
    
        // $modifiedArray now contains the modified array without created_at and updated_at
        return $modifiedArray;
    }

    public function formPreview(Request $request)
    {

        $applicant = Application::where('id', $request->application_id)->first();
       
        if (empty($applicant)) {
           $response = [
            'status' => '0',
            'message' => 'no record found'
           ];
        }
        else
        {
            $applicantDetails = ApplicantDetails::where('application_id', $request->application_id)->first();

           
            $applicantDetailsFrontend = '';
            if(!empty($applicantDetails)){
            $applicantDetailsFrontend = $this->getModifiedaApplicantDetails($applicantDetails->toArray());
            }


            $parentDetails = ParentDetails::where('application_id', $request->application_id)->first();

            $parentDetailsFrontend = '';
            if(!empty($parentDetails)){
            $parentDetailsFrontend = $this->getModifiedParentDetails($parentDetails->toArray());
            }

            $academics = Academics::where('application_id', $request->application_id)->first();

            $academicsFrontend = '';
            if(!empty($academics)){
            $academicsFrontend = $this->getModifiedAcademics($academics->toArray());
            }

            $awardsRecognition = AwardsRecognition::where('application_id', $request->application_id)->first();

            $awardRecognitionFrontend = '';
            if(!empty($awardsRecognition)){
            $awardRecognitionFrontend = $this->getModifiedAwardRecognition($awardsRecognition->toArray());
            }
                        

            $scholarship = Scholarship::where('application_id', $request->application_id)->first();

            $scholarshipFrontend = '';
            if(!empty($scholarship)){
            $scholarshipFrontend = $this->getModifiedScholarship($scholarship->toArray());
            }

            $documents = Documents::where('application_id', $request->application_id)->first();

            $documentFrontend = '';
            if(!empty($documents)){
            $documentFrontend = $this->getModifiedDocument($documents->toArray());
            }
                        
            $finalStepsOrder = getSetting("steps_order");
        
            //checking step status
            $stepWithStaus = $this->checkStepStatus($finalStepsOrder, $request->application_id);

            $percentage = $this->calculateStatusPercentage($stepWithStaus);

            //fetching next and prev steps
            $currentStep = "preview";
            $currentIndex = array_search($currentStep, $finalStepsOrder);
        
            $nextIndex = $currentIndex + 1;
            $prevIndex = $currentIndex - 1;

            $response = [
                'status' => '1',
                'message' => 'success',
                'data' =>  [
                    'applicantDetailsFields' => $applicantDetailsFrontend, 
                    'parentDetailsFields' => $parentDetailsFrontend,
                    'academicsFields' => $academicsFrontend,
                    'awardRecognitionFields' => $awardRecognitionFrontend,
                    'scholarshipFields' => $scholarshipFrontend,
                    'documentsFields' => $documentFrontend,
                    'steps' => $stepWithStaus,
                    'nextStep' => isset($finalStepsOrder[$nextIndex]) ? $finalStepsOrder[$nextIndex] : -1,
                    'prevStep' => isset($finalStepsOrder[$prevIndex]) ? $finalStepsOrder[$prevIndex]  : -1,
                    'completePercentage' => $percentage
                    
                ]
            ];
        }

        return response()->json($response, 201);
    }

    public function saveFormPreview(Request $request)
    {
        $application = Application::where('id', $request->application_id)->first();

        if($application)
        {
            $application->status = 1;
            $application->save();
            $response = [
                'message' => 'preview saved successfully',
                'status' => '1',
            ];
        }
        else
        {
            $response = [
                'message' => 'application not exists',
                'status' => '0',
            ];
        }
        return response()->json($response, 201);
    }
}
