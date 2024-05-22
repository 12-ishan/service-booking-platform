<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OurServices;


class OurServicesController extends Controller
{
   
    public function index(Request $request)
    {
        $services = OurServices::where('status', 1)->orderBy('sortOrder')->limit(6)->get();
        $data = [];

        foreach ($services as $service) {
            $mediaName = url('/') . "/uploads/services/" . getMediaName($service['imageId']); 
            $data[] = [
                'id' => $service['id'],
                'title' => $service['title'],
                'media_name' => $mediaName,
                'description' => $service['description']
            ];
        }

        if (empty($services)) {
            $response = [
                'message' => 'service not exist',
                'status' => '0',
            ];
        } else {
            $response = [
                'message' => 'service exist',
                'status' => '1',
                'data' => $data
            ];
        }

        return response()->json($response, 201);
    }



}
    


   
   

