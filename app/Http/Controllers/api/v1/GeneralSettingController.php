<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\GeneralSettings;

class GeneralSettingController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        // if ($type !== 'contact') {
        //     $response = [
        //         'message' => 'does not exist',
        //         'status' => '0',
        //     ];
        // } else {
            $generalSetting = GeneralSettings::where('type', 'contact')->first();

            if (empty($generalSetting)) {
                $response = [
                    'message' => 'does not exist',
                    'status' => '0',
                ];
            } else {
                $response = [
                    'message' => 'exist',
                    'status' => '1',
                    'data' => $generalSetting
                ];
        return response()->json($response, 201);
    }
}
}