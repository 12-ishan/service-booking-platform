<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Subject;
use App\Models\Admin\Program;
use Illuminate\Support\Facades\Auth;


class SubjectController extends Controller
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

        $data["subject"] = Subject::orderBy('sortOrder')->get();
      

        $data["pageTitle"] = 'Manage Subject';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'subject';
        return view('admin.subject.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["program"] = Program::where('status',1)->orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Add Subject';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'subject';
        return view('admin.subject.create')->with($data);
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
            'name' => 'required',
            'programId' => 'required',
        ],
        [
            'name.required'=> 'Suject name is required', // name message
            'programId.required'=> 'Program name is required', // program name message
        ]
    );

        $subject = new Subject();

      

            $subject->name = $request->input('name');
            $subject->programId = $request->input('programId');
            $subject->description = $request->input('description');
       
        $subject->status = 1;
        $subject->sortOrder = 1;

        $subject->increment('sortOrder');

        $subject->save();

        return redirect()->route('subject.index')->with('message', 'Subject Added Successfully');
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

        $data['subject'] = Subject::find($id);
        $data["program"] = Program::orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Subject';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'subject';
        return view('admin.subject.create')->with($data);
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
            'name' => 'required',
        ],
        [
            'name.required'=> 'Suject name is required', // name message
        ]);
        
        $id = $request->input('id');

        $subject = Subject::find($id);

       
        $subject->name = $request->input('name');
        $subject->programId = $request->input('programId');
        $subject->description = $request->input('description');

        $subject->save();

        return redirect()->route('subject.index')->with('message', 'Subject Updated Successfully');
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
        $subject = Subject::find($id);
        $subject->delete($id);

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
                $subject = Subject::find($id);
                $subject->delete();
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
                $subject = Subject::find($id);
                $subject->sortOrder = $values->position;
                $result = $subject->save();
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

        $subject = Subject::find($id);
        $subject->status = $status;
        $result = $subject->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

     /**
     * Get Subject By Program Id resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubjectByProgramId(Request $request)
    {
        $programId = $request->programId;
        $subject = Subject::where('programId', $programId)->where('status', 1)->get();

        $html = '<option value="">Select Subject</option>';

        foreach ($subject as $value) {
            $html .= "<option value='" . $value->id . "'>" . $value->name . "</option>";
        }

        if (!empty($html)) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => $html);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
