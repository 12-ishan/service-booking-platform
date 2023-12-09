<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\QuestionCategory;
use App\Models\Admin\Program;
use App\Models\Admin\Subject;
//use App\Models\Admin\States;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;


class QuestionCategoryController extends Controller
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

        $query = QuestionCategory::orderBy('id','DESC');
        if(auth()->user()->roleId != '1'){
            $query = $query->where('userId', Auth::user()->id);
        }
        $data["questionCategory"] = $query->get();

        $data["pageTitle"] = 'Manage Question Category';
        $data["activeMenu"] = 'question';
        $data["activeSubMenu"] = 'questionCategory';
        return view('admin.questionCategory.manage')->with($data);
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
       // $data["state"] = States::where('status',1)->orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Add Question Category';
        $data["activeMenu"] = 'question';
        $data["activeSubMenu"] = 'questionCategory';
        return view('admin.questionCategory.create')->with($data);
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
            'stateId' => 'required',
            'name' => 'required',
        ],
        [
            'programId.required'=> 'Program name is required',
            'subjectId.required'=> 'subject name is required',
            'stateId.required'=> 'State name is required',
            'name.required'=> 'Question category name is required',

        ]
    );

        $questionCategory = new QuestionCategory();

        $user = auth()->user();
        $userId = $user->id;

        $questionCategory->userId = $userId;
        $questionCategory->programId = $request->input('programId');
        $questionCategory->subjectId = $request->input('subjectId');
        //$questionCategory->stateId = $request->input('stateId');
        $questionCategory->name = $request->input('name');
        $questionCategory->description = $request->input('description');
       
        $questionCategory->status = 1;
        $questionCategory->sortOrder = 1;

        $questionCategory->increment('sortOrder');

        $questionCategory->save();

        return redirect()->route('question-category.index')->with('message', 'Question Category Added Successfully');
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

        $data['questionCategory'] = QuestionCategory::find($id);
        $data["program"] = Program::where('status',1)->orderBy('sortOrder')->get();
        $data["subject"] = Subject::where('status',1)->orderBy('sortOrder')->get();
       // $data["state"] = States::where('status',1)->orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Question Category';
        $data["activeMenu"] = 'question';
        $data["activeSubMenu"] = 'questionCategory';
        return view('admin.questionCategory.create')->with($data);
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
        ]);
        
        $id = $request->input('id');

        $questionCategory = QuestionCategory::find($id);

       
        $questionCategory->name = $request->input('name');
        $questionCategory->description = $request->input('description');

        $questionCategory->save();

        return redirect()->route('question-category.index')->with('message', 'Question Category Updated Successfully');
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
        $questionCategory = QuestionCategory::find($id);
        $questionCategory->delete($id);

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
                $questionCategory = QuestionCategory::find($id);
                $questionCategory->delete();
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
                $questionCategory = QuestionCategory::find($id);
                $questionCategory->sortOrder = $values->position;
                $result = $questionCategory->save();
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

        $questionCategory = QuestionCategory::find($id);
        $questionCategory->status = $status;
        $result = $questionCategory->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
