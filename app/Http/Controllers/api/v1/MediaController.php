<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Frontend\ApplicantDetails;

use Illuminate\Http\Request;
use Validator;

class MediaController extends Controller
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

    

    public function mediaUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
       
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
        }


        $imageId = $this->checkImageAlreadyUploaded($request->key, $request->application_id);

       
        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUploadApi($request->image, $imageId, "uploads/applications/"); //Image, ReferenceRecordId, Path
          
         }

         $this->setNewMedia($request->key, $request->application_id, $mediaId);

    
            $response = [
                'message' => 'image uplaoded successfully',
                'status' => 'success'
            ];
       
     
        return response()->json($response, 201);
    }

    private function setNewMedia($key, $applicationId, $mediaId)
    {

        switch($key) {
            case 'personal_profile':

                $ad = ApplicantDetails::where('application_id', $applicationId)->first();
                $ad->pd_profile_id = $mediaId;
                $ad->save();
                return $ad;
                

            // Add cases for other stages if needed

            default:
                return 0; // Default to false if the stage is not found
        }

    }

    private function checkImageAlreadyUploaded($key, $applicationId)
    {
        
        //$applicationId = 3;

        switch($key) {
            case 'personal_profile':

                $ad = ApplicantDetails::where('application_id', $applicationId)->first();
                return  $ad->pd_profile_id;
                

            // Add cases for other stages if needed

            default:
                return 0; // Default to false if the stage is not found
        }
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
