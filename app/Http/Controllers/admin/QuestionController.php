<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Question;
use App\Models\Admin\QuestionCategory;
use App\Models\Admin\QuestionOption;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\User;


class QuestionController extends Controller
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

        $query = Question::orderBy('id','DESC');
        if(auth()->user()->roleId != '1'){
            $query = $query->where('userId', Auth::user()->id);
        }
        $data["question"] = $query->get();
      
        $data["pageTitle"] = 'Manage Question';
        $data["activeMenu"] = 'question';
        return view('admin.question.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["questionCategory"] = QuestionCategory::where('status',1)->orderBy('sortOrder')->get();


        $data["pageTitle"] = 'Add Question';
        $data["activeMenu"] = 'question';
        return view('admin.question.create')->with($data);
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
            'question' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $question = new Question();

        // Image Uploading

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $question->imageId, $this->userId, "uploads/question/"); //Image, ReferenceRecordId, UserId, Path
            
            $question->imageId = $mediaId;
 
         }

        $user = auth()->user();
        $userId = $user->id;

        $question->userId = $userId;
        $question->question = $request->input('question');
        $question->questionCategoryId = $request->input('questionCategoryId');
            
        $question->type = $request->input('type');
        $question->marks = $request->input('marks');
         
        $question->status = 1;
        $question->sortOrder = 1;

        $question->increment('sortOrder');

        $question->save();

        $questionId = $question->id;

        $option = $request->input('option');
        $isCorrect = $request->input('isCorrect');
        
        if($option != NULL && $isCorrect != NULL){
        $i= 0;
        foreach ($option as $value) {
            
           
            $questionOption = new QuestionOption();
            $questionOption->status = 1;
            $questionOption->sortOrder = 1;
            $questionOption->option = $option[$i];  
            $questionOption->isCorrect = $isCorrect[$i]; 
            $questionOption->questionId = $questionId; 
            $questionOption->save();
            
         $i++;  }
        }

        return redirect()->route('question.index')->with('message', 'Question Added Successfully');
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

        $data['question'] = Question::find($id);
        $data["questionCategory"] = QuestionCategory::orderBy('sortOrder')->get();
        $data["questionOption"] = QuestionOption::where('questionId',$id)->orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Question';
        $data["activeMenu"] = 'question';
        return view('admin.question.create')->with($data);
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
            'question' => 'required',
        ]);
        
        $id = $request->input('id');

        $question = Question::find($id);

         // Image Uploading

         if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $question->imageId, $this->userId, "uploads/question/"); //Image, ReferenceRecordId, UserId, Path
            
            $question->imageId = $mediaId;
 
         }

         $question->question = $request->input('question');
         $question->questionCategoryId = $request->input('questionCategoryId');
         $question->type = $request->input('type');
         $question->marks = $request->input('marks');

        $question->save();

        $insertedId = $question->id;

        $option = $request->input('option');
        $isCorrect = $request->input('isCorrect');
        $questionOptionId = $request->input('questionOptionId');

        // Deleting extra entries

        if(empty($questionOptionId)){

            $questionOptionId = array();
        }

        $del = QuestionOption::where('questionId', $insertedId)->whereNotIn('id', $questionOptionId)->delete();

        $i=0;

        if(isset($option)){
        
        foreach ($option as $value) {

           if(isset($questionOptionId[$i]) && !empty($questionOptionId[$i])){

            //update this record
            
            $qoId = $questionOptionId[$i];
            $questionOption = QuestionOption::find($qoId);
           

           }else{

            //insert this record

            $questionOption = new QuestionOption();
            $questionOption->status = 1;
            $questionOption->sortOrder = 1;
            $questionOption->questionId = $insertedId;
            
           }

           $questionOption->option = $option[$i];
           $questionOption->isCorrect = $isCorrect[$i];   
           $questionOption->save();

        $i++;}}

        return redirect()->route('question.index')->with('message', 'Question Updated Successfully');
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
        $question = Question::find($id);
        $question->delete($id);

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
                $question = Question::find($id);
                $question->delete();
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
                $question = Question::find($id);
                $question->sortOrder = $values->position;
                $result = $question->save();
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

        $question = Question::find($id);
        $question->status = $status;
        $result = $question->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}