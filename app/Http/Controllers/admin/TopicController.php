<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Topic;
use App\Models\Admin\User;
use App\Models\Admin\Program;
use App\Models\Admin\Subject;
use Illuminate\Support\Facades\Auth;
use DB;


class TopicController extends Controller
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

        $data["topic"] = Topic::orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Manage Topic';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'topic';
        return view('admin.topic.manage')->with($data);
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

        $data["pageTitle"] = 'Add Topic';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'topic';
        return view('admin.topic.create')->with($data);
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
            'programId' => 'required',
            'subjectId' => 'required',
            'title' => 'required',
        ]
    );
     
        $topic = new Topic();

        $topic->programId = $request->input('programId');
        $topic->subjectId = $request->input('subjectId');
        $topic->title = $request->input('title');
       
        $topic->status = 1;
        $topic->sortOrder = 1;

        $topic->increment('sortOrder');

        $topic->save();

        return redirect()->route('topic.index')->with('message', 'Topic Added Successfully');
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

        $data['topic'] = Topic::find($id);

        $data["program"] = Program::where('status',1)->orderBy('sortOrder')->get();
        $data["subject"] = Subject::orderBy('sortOrder')->get();
        $data["role"] = User::where('roleId',2)->orderBy('id')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Topic';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'topic';
        return view('admin.topic.create')->with($data);
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
            'title' => 'required',
        ]);


        $id = $request->input('id');

        $topic = Topic::find($id);

        $id = $request->input('id');

        $topic = Topic::find($id);

        $topic->programId = $request->input('programId');
        $topic->subjectId = $request->input('subjectId');
        $topic->title = $request->input('title');

        $topic->save();

        return redirect()->route('topic.index')->with('message', 'Topic Updated Successfully');
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
        $topic = Topic::find($id);
        $topic->delete($id);

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
                $topic = Topic::find($id);
                $topic->delete();
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
                $topic = Topic::find($id);
                $topic->sortOrder = $values->position;
                $result = $topic->save();
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

        $topic = Topic::find($id);
        $topic->status = $status;
        $result = $topic->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

  



}