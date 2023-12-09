<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\TeacherClass;
use App\Model\Admin\User;
use App\Model\Admin\Program;
use App\Model\Admin\Subject;
use Illuminate\Support\Facades\Auth;
use DB;


class TeacherClassController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->accountId = Auth::user()->accountId;
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

        $data["teacherClass"] = TeacherClass::orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Manage Class Teacher';
        $data["activeMenu"] = 'teacher-class';
        return view('admin.teacherClass.manage')->with($data);
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
        $data["role"] = User::where('roleId',2)->orderBy('id')->get();

        $data["pageTitle"] = 'Add Class Teacher';
        $data["activeMenu"] = 'teacher-class';
        return view('admin.teacherClass.create')->with($data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //     $this->validate(request(), [
    //         'programId' => 'required|unique:teacher_class',
    //         'subjectId' => 'required|unique:teacher_class',
    //         'teacherId' => 'required|unique:teacher_class',
    //     ]
    // );

        $this->validate(request(), [
            'programId' => 'required',
            'subjectId' => 'required',
            'teacherId' => 'required',
        ]
        );

        $programId = $request->input('programId');
        $subjectId = $request->input('subjectId');
        $teacherId = $request->input('teacherId');

        $recordData = $this->checkUniqueTeacher($programId, $subjectId, $teacherId);

        if($recordData){

           return redirect('/admin/teacher-class/create')->with('message', 'Teacher already assigned duplicate entry');
           die();

        }
     
        $teacherClass = new TeacherClass();

            $teacherClass->programId = $programId;
            $teacherClass->subjectId = $subjectId;
            $teacherClass->teacherId = $teacherId;
       
        $teacherClass->status = 1;
        $teacherClass->sortOrder = 1;

        $teacherClass->increment('sortOrder');

        $teacherClass->save();

        return redirect()->route('teacher-class.index')->with('message', 'Teacher Class Added Successfully');
    }


    public function checkUniqueTeacher($programId, $subjectId, $teacherId)
    {
        $teacherRecord = TeacherClass::where('programId', $programId)->where('subjectId', $subjectId)->where('teacherId', $teacherId)->first();

        return $teacherRecord;
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

        $data['teacherClass'] = TeacherClass::find($id);

        $data["program"] = Program::where('status',1)->orderBy('sortOrder')->get();
        $data["subject"] = Subject::orderBy('sortOrder')->get();
        $data["role"] = User::where('roleId',2)->orderBy('id')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Class Teacher';
        $data["activeMenu"] = 'teacher-class';
        return view('admin.teacherClass.create')->with($data);
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
            'programId' => 'required',
            'subjectId' => 'required',
            'teacherId' => 'required',
        ]);




            $id = $request->input('id');

            $programId = $request->input('programId');
            $subjectId = $request->input('subjectId');
            $teacherId = $request->input('teacherId');

            $recordData = $this->checkUniqueTeacher($programId, $subjectId, $teacherId);

            if($recordData){

            return redirect('/admin/teacher-class/'.$id.'/edit')->with('message', 'Teacher already assigned duplicate entry');
            die();

            }

            $teacherClass = TeacherClass::find($id);

        $id = $request->input('id');

        $teacherClass = TeacherClass::find($id);

        $teacherClass->programId = $programId;
        $teacherClass->subjectId = $subjectId;
        $teacherClass->teacherId = $teacherId;
        $teacherClass->save();

        return redirect()->route('teacher-class.index')->with('message', 'TeacherClass Updated Successfully');
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
        $teacherClass = TeacherClass::find($id);
        $teacherClass->delete($id);

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
                $teacherClass = TeacherClass::find($id);
                $teacherClass->delete();
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
                $teacherClass = TeacherClass::find($id);
                $teacherClass->sortOrder = $values->position;
                $result = $teacherClass->save();
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

        $teacherClass = TeacherClass::find($id);
        $teacherClass->status = $status;
        $result = $teacherClass->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

  



}