<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Admin\Payment;

class RazorpayPaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
          
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $orderData = [
                'receipt'         => uniqid(),
                'amount'          => $request->amount * 100, //5 * 100, 
                'currency'        => 'INR',  
            ];
          
            $order = $api->order->create($orderData);
        
            $payment = new Payment();
            $payment->order_id = $order['id'];
            $payment->amount = $order['amount'] / 100;
            $payment->currency = $order['currency'];
            $payment->save();

            return response()->json([
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'receipt' => $order['receipt']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storePayment(Request $request)
    {
       
        try {
            $payment = Payment::where('order_id', $request->order_id)->first();
            if ($payment) {
                $payment->payment_id = $request->payment_id;
                $payment->status = 'paid';
                $payment->save();

                return response()->json(['message' => 'Payment stored successfully']);
            }

            return response()->json(['message' => 'Order not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
