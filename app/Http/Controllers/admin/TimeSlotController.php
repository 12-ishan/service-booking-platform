<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\TimeSlot;
use Illuminate\Support\Facades\Auth;


class TimeSlotController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
        
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();

        $data["timeSlot"] = TimeSlot::orderBy('sortOrder')->get();
      

        $data["pageTitle"] = 'Manage Time Slot';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'timeSlot';
        return view('admin.timeSlot.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Time Slot';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'timeSlot';
        return view('admin.timeSlot.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
          //  'name' => 'required|unique:time_slot',
          'fromTime' => 'required',
          'toTime' => 'required',
        ],
        [
            'fromTime.required'=> 'From Date is required',
            'toTime.required'=> 'To Date is required',
         //   'unique' => 'The time slot has already been taken.',
        ]);

        $timeSlot = new TimeSlot();
       // $timeSlot->name = $request->input('name');
       $timeSlot->fromTime = $request->input('fromTime');
       $timeSlot->toTime = $request->input('toTime');
        $timeSlot->status = 1;
        $timeSlot->sortOrder = 1;
        $timeSlot->increment('sortOrder');
        $timeSlot->save();

        return redirect()->route('time-slot.index')->with('message', 'Time Slot Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data = array();

        $data['timeSlot'] = TimeSlot::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update TimeSlot';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'timeSlot';
        return view('admin.timeSlot.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate(request(), [
            //  'name' => 'required|unique:time_slot',
            'fromTime' => 'required',
            'toTime' => 'required',
          ],
          [
              'fromTime.required'=> 'From Date is required',
              'toTime.required'=> 'To Date is required',
           //   'unique' => 'The time slot has already been taken.',
          ]);
  
        
        $id = $request->input('id');
        $timeSlot = TimeSlot::find($id);
       // $timeSlot->name = $request->input('name');
       $timeSlot->fromTime = $request->input('fromTime');
       $timeSlot->toTime = $request->input('toTime');
        $timeSlot->save();

        return redirect()->route('time-slot.index')->with('message', 'Time Slot Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $timeSlot = TimeSlot::find($id);
        $timeSlot->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }

    /**
     * Remove all selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $timeSlot = TimeSlot::find($id);
                $timeSlot->delete();
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }

    /**
     * Update SortOrder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSortorder(Request $request)
    {
        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;

        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $timeSlot = TimeSlot::find($id);
                $timeSlot->sortOrder = $values->position;
                $result = $timeSlot->save();
            }
        }

        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }

        return response()->json($response);
    }

    /**
     * Update Status resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        $timeSlot = TimeSlot::find($id);
        $timeSlot->status = $status;
        $result = $timeSlot->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
