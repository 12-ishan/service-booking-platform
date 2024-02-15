<?php
use Illuminate\Support\Facades\File;
use App\Models\Admin\Media;
// use App\Model\Admin\Setting;
// use App\Model\Admin\Country;
use App\Models\Admin\GlobalSetting;
use App\Models\Admin\Setting;

if (! function_exists('imageUpload')) {

    function imageUpload($image, $referencedImageId, $userId, $path) {
   
        $imageName =  time() . "_" . $image->getClientOriginalName();

            $image->move(public_path($path), $imageName);  // Upload imgae to specified folder

            $mediaRecord = Media::orderBy('sortOrder')->where('userId', $userId)->where('id', $referencedImageId)->first();

            //Check if Media record exits for particular if not then add other wise update

            if (empty($mediaRecord)) {

                $media = new Media();

            } else {

                $media = Media::find($mediaRecord->id);

                $image_path = $path . $media->name;  // Deleting image from directory

                if (File::exists($image_path)) {
                    
                    File::delete($image_path);
                }
            }

            $media->name = $imageName;

            if (empty($mediaRecord)) {

                $media->userId = $userId;
                $media->status = 1;
                $media->sortOrder = 1;
                $media->increment('sortOrder');
            }

            $media->save();

            return $media->id;

    }
}


if (! function_exists('imageUploadApi')) {

    function imageUploadApi($image, $referencedImageId, $path) {
   
           $imageName =  time() . "_" . $image->getClientOriginalName();

           $image->move(public_path($path), $imageName);  //Upload imgae to specified folder

            $mediaRecord = Media::orderBy('sortOrder')->where('id', $referencedImageId)->first();

            //Check if Media record exits for particular if not then add other wise update

            if (empty($mediaRecord)) {

                $media = new Media();

            } else {

                $media = Media::find($mediaRecord->id);

                $image_path = $path . $media->name;  // Deleting image from directory

                if (File::exists($image_path)) {
                    
                    File::delete($image_path);
                }
            }

            $media->name = $imageName;

            if (empty($mediaRecord)) {

                // $media->userId = $userId;
                $media->status = 1;
                $media->sortOrder = 1;
                $media->increment('sortOrder');
            }

            $media->save();

            return $media->id;

    }
}

if (! function_exists('getMediaName')) {

    function getMediaName($id) {
   

            $mediaRecord = Media::orderBy('sortOrder')->where('id', $id)->first();

            //Check if Media record exits for particular if not then add other wise update

            if (empty($mediaRecord)) {

              return 0;
            } else {

                return $mediaRecord->name;
             
            }

    }
}

if (! function_exists('generateRandomOtp')) {

        function generateRandomOtp($number) {
 
         return str_pad(rand(0, 999999), $number, '0', STR_PAD_LEFT);
       }
}

if (! function_exists('getSetting')) {

        function getSetting($key) {
 
            $finalSetting = '';
      
            $organisationSetting = Setting::where('organisationId', 1)->first();
           
            if(isset($organisationSetting) && !empty($organisationSetting[$key])) {
              
            $orgSetting = json_decode($organisationSetting[$key], true);
          
            $finalSetting = $orgSetting;
    
           }
    
    
            if(empty($finalSetting)){
               
                $settings = GlobalSetting::first(); // Assuming you have only one row in the settings table
            
                $globalSetting = json_decode($settings[$key],true);
               
                $finalSetting = $globalSetting; 
              
            }
    
            return $finalSetting;
       }
}


// /////////

// if (! function_exists('pdfUpload')) {

//     function pdfUpload($fileName,$userId) {
   
//             $media = new Media();
//             $media->name = $fileName;
//             $media->userId = $userId;
//             $media->status = 1;
//             $media->sortOrder = 1;
//             $media->increment('sortOrder');

//             $media->save();

//             return $media->id;

//     }
// }

// /////////

// if (! function_exists('getSettingByUser')) {

//     function getSettingByUser($userId) {
   
//             $userSettingData = Setting::where('userId', $userId)->orderBy('sortOrder')->first();

//             return $userSettingData;

//     }
// }


// /////////

// if (! function_exists('findCountryIdByName')) {

//     function findCountryIdByName($name) {

//         $country = Country::where('name', $name)->first();
        
//         return $country->id;

//     }
// }


?>