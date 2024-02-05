<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PaymentHistory;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisation_id = Auth::user()->organisation_id;    
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = array();
        $data["paymentHistory"] = PaymentHistory::orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage Payment History';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'paymentHistory';
        return view('admin.paymentHistory.manage')->with($data);
       
    }

   
    public function store(Request $request)
    {
        //

        $paymentHistory = new PaymentHistory();
        $paymentHistory->status = 1;
        $paymentHistory->sort_order = 1;
        $paymentHistory->increment('sort_order');
        $paymentHistory->save();
        return redirect()->route('paymenthistory.index')->with('message', 'Payment history Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');
        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $city = City::find($id);
                $city->delete();
            }
        }
        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }

    public function updateSortorder(Request $request)
    {
        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;
        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $city = City::find($id);
                $city->sort_order = $values->position;
                $result = $city->save();
            }
        }
        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }
        return response()->json($response);
    }

    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        $city = City::find($id);
        $city->status = $status;
        $result = $city->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}

