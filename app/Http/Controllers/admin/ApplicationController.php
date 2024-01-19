<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Student;
use App\Models\Admin\Application;
use App\Models\Admin\GlobalSetting;
use App\Models\Admin\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisationId = Auth::user()->organisationId;
        
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array();

       
        $finalColumnSettings = '';

        $organisationSetting = Setting::where('organisationId', $this->organisationId)->first();

        if(isset($organisationSetting)) {

        $orgColumnSettings = json_decode($organisationSetting->application_table_order, true);
        
        $finalColumnSettings = $orgColumnSettings;

       }


        if(empty($finalColumnSettings)){

            $settings = GlobalSetting::first(); // Assuming you have only one row in the settings table

            $columnSettings = json_decode($settings->application_table_order, true);

            $finalColumnSettings = $columnSettings;

        }

        $application = Application::orderBy('sort_order')->get();

        $pageTitle = 'Manage Application';
        $activeMenu = 'application';
      
        return view('admin.application.manage', compact('pageTitle', 'activeMenu', 'application', 'finalColumnSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();

        $data["student"] = Student::where('status',1)->orderBy('sort_order')->get();
  
        $data["pageTitle"] = 'Add Application';
        $data["activeMenu"] = 'application';
        return view('admin.application.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(), [
            'studentId' => 'required',
            'applicationNumber' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'lastDate' => 'required',
        ],
       
    );

        $application = new Application();

        $application->student_id = $request->input('studentId');
        $application->application_number = $request->input('applicationNumber');
        $application->start_time = $request->input('startTime');
        $application->end_time = $request->input('endTime');
        $application->last_date = $request->input('lastDate');
        $application->description = $request->input('description');
        $application->status = 1;
        $application->sort_order = 1;

        $application->increment('sort_order');

        $application->save();

        return redirect()->route('application.index')->with('message', 'Application Added Successfully');
    }


    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $data = array();

        $data['application'] = Application::find($id);
        $data["student"] = Student::orderBy('sort_order')->get();
      
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Application';
        $data["activeMenu"] = 'applicationManager';
        return view('admin.application.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validate(request(), [
            'studentId' => 'required',
            'applicationNumber' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'lastDate' => 'required',
        ]);
        
        $id = $request->input('id');
       
        $application = Application::find($id);
       
        $application->student_id = $request->input('studentId');
        $application->application_number = $request->input('applicationNumber');
        $application->start_time = $request->input('startTime');
        $application->end_time = $request->input('endTime');
        $application->last_date = $request->input('lastDate'); 
        $application->description = $request->input('description'); 
        $application->status = 1;
        $application->sort_order = 1;

        $application->save();

        return redirect()->route('application.index')->with('message', 'Application Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $application = Application::find($id);
        $application->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }

    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $application = Application::find($id);
                $application->delete();
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
                $application = Application::find($id);
                $application->sortOrder = $values->position;
                $result = $application->save();
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

        $application = Application::find($id);
        $application->status = $status;
        $result = $application->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}


