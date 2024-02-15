<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Frontend\ApplicantDetails;
use App\Models\Frontend\Scholarship;
use App\Models\Frontend\Documents;


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

       $imageInfo =  $this->setNewMedia($request->key, $request->application_id, $mediaId);
     
            $response = [
                'message' => 'image uplaoded successfully',
                'status' => 'success',
                'data' => $imageInfo
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
                return  url('/') . "/uploads/applications/" . $ad->pdProfile->name;
                
            case 'explanation_document':
                $ed = Scholarship::where('application_id', $applicationId)->first();
                $ed->explanation_document_id = $mediaId;
                $ed->save();
                return  url('/') . "/uploads/applications/" . $ed->explanationDocument->name;

            case 'highschool_markssheet':
                $hm = Documents::where('application_id', $applicationId)->first();
                $hm->highschool_markssheet_id = $mediaId;
                $hm->save();
                return  url('/') . "/uploads/applications/" . $hm->highschoolMarksheet->name;

            case 'inter_markssheet':
                $im = Documents::where('application_id', $applicationId)->first();
                $im->inter_markssheet_id = $mediaId;
                $im->save();
                return  url('/') . "/uploads/applications/" . $im->interMarksheet->name;

            case 'consolidated_marksheet':
                $cm = Documents::where('application_id', $applicationId)->first();
                $cm->consolidated_marksheet_id = $mediaId;
                $cm->save();
                return  url('/') . "/uploads/applications/" . $cm->consolidatedMarksheet->name;

            case 'consolidated_certificate':
                $cc = Documents::where('application_id', $applicationId)->first();
                $cc->consolidated_certificate_id = $mediaId;
                $cc->save();
                return  url('/') . "/uploads/applications/" . $cc->consolidatedCertificate->name;

            case 'aadhar_card':
                $ar = Documents::where('application_id', $applicationId)->first();
                $ar->aadhar_card_id = $mediaId;
                $ar->save();
                return  url('/') . "/uploads/applications/" . $ar->aadharCard->name;

            case 'signature':
                $s = Documents::where('application_id', $applicationId)->first();
                $s->signature_id = $mediaId;
                $s->save();
                return  url('/') . "/uploads/applications/" . $s->signature->name;
                            
                        

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

            case 'explanation_document':
                $ed = Scholarship::where('application_id', $applicationId)->first();
                return $ed->explanation_document_id;

            case 'highschool_markssheet':
                $hm = Documents::where('application_id', $applicationId)->first();
                return $hm->highschool_markssheet_id;

            case 'inter_markssheet':
                $im = Documents::where('application_id', $applicationId)->first();
                return $im->inter_markssheet_id;

            case 'consolidated_marksheet':
                $cm = Documents::where('application_id', $applicationId)->first();
                return $cm->consolidated_marksheet_id;

            case 'consolidated_certificate':
                $cc = Documents::where('application_id', $applicationId)->first();
                return $cc->consolidated_certificate_id;

            case 'aadhar_card':
                $ar = Documents::where('application_id', $applicationId)->first();
                return $ar->aadhar_card_id;

            case 'signature':
                $s = Documents::where('application_id', $applicationId)->first();
                return $s->signature_id;
                        
            // Add cases for other stages if needed

            default:
                return 0; // Default to false if the stage is not found
        }
    }

}
