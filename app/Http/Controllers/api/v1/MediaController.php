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

}
