<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frontend\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentManagerController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = array();
        $data["student"] = Student::orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage Student';
        $data['activeMenu'] = 'studentManager';
        return view('admin.studentManager.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data["pageTitle"] = 'Add Student';
        $data["activeMenu"] = 'studentManager';
        return view('admin.studentManager.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
            
        ]);

        $student = new Student();

        $password = $request->input('password');

        $student->first_name = $request->input('firstName');
        $student->last_name = $request->input('lastName');
        $student->email = $request->input('email');
        $student->password = Hash::make($password);
        $student->status = 1;
        $student->sort_order = 1;
        $student->increment('sort_order');
        $student->save();
        return redirect()->route('studentManager.index')->with('message', 'Student Added Successfully');
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
        $data['student'] = Student::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate Student";
        $data['activeMenu'] = 'studentManager';
        return view('admin.studentManager.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
          //
          $this->validate(request(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
            
        ]);
        $id = $request->input('id');
        $student = Student::find($id);

        $student->first_name = $request->input('firstName');
        $student->last_name = $request->input('lastName');
        $student->email = $request->input('email');
        
        $password = $request->input('password');
        $student->password = Hash::make($password);
        $student->status = 1;
        $student->sort_order = 1;
        $student->increment('sort_order');
        $student->save();
        return redirect()->route('studentManager.index')->with('message', 'Student Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $student = student::find($id);
        $student->delete($id);
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
                $student = Student::find($id);
                $student->delete();
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
                $student = Student::find($id);
                $student->sort_order = $values->position;
                $result = $student->save();
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
        $student = Student::find($id);
        $student->status = $status;
        $result = $student->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}

