<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;



class CouponController extends Controller
{
    //
    public function couponDetails(Request $request)
    {
        $checkCoupon = Coupon::where('id', $request->coupon_id)->where('status', 1)->first();
    
        if (empty($checkCoupon)) {

            $response = [
                'message' => 'coupon  not exists',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'message' => 'coupon exists',
                'status' => '1'
            ];
        }
    
        return response()->json($response, 201);
    }    
}


   
   

