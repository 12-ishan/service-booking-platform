<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Meeting;
use App\Models\Admin\QuestionCategory;
//use App\Models\Admin\SessionContant;
// use App\Models\Admin\TeacherClass;
use App\Models\Admin\User;
use App\Models\Admin\Program;
use App\Models\Admin\Subject;
use App\Models\Admin\Topic;
// use App\Model\Admin\States;
use App\Models\Admin\TimeSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DB;

class MeetingController extends Controller
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


        $query = Meeting::orderBy('id','DESC');
        if(auth()->user()->roleId != '1'){
            $query = $query->where('tutorId', Auth::user()->id);
        }
        $data["meeting"] = $query->get();

        $data["pageTitle"] = 'Manage Session';
        $data["activeMenu"] = 'meeting';
        return view('admin.meeting.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = array();
        $data["questionCategory"] = QuestionCategory::orderBy('sortOrder')->get();
        $data["program"] = Program::where('status',1)->orderBy('sortOrder')->get();
        $data["state"] = States::where('status',1)->orderBy('sortOrder')->get();
        $data["sessionRecieverId"] = User::Where('roleId','4')->where('status',1)->orderBy('sortOrder')->get();
        $data["timeSlot"] = TimeSlot::where('status',1)->orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Add Meeting';
        $data["activeMenu"] = 'meeting';

        return view('admin.meeting.create')->with($data);
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
            'topicId' => 'required',
            'stateId' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $meeting = new Meeting();

        // Image Uploading

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $meeting->imageId, $this->userId, "uploads/meeting/"); //Image, ReferenceRecordId, UserId, Path
            
            $meeting->imageId = $mediaId;
 
         }
        $meeting->programId = $request->input('programId');
        $meeting->subjectId = $request->input('subjectId');
        $meeting->topicId = $request->input('topicId');
        $meeting->tutorId = $request->input('tutorId');
        $meeting->sessionRecieverId = $request->input('sessionRecieverId');
        $meeting->stateId = $request->input('stateId');
        $meeting->date = $request->input('date');
        $meeting->timeSlotId = $request->input('timeSlotId');
        $meeting->name = $request->input('name');
        $meeting->description = $request->input('description');
        $meeting->practiceSetQuestionId = $request->input('practiceSetQuestionId');
       
        $meeting->status = 1;
        $meeting->sortOrder = 1;

        $meeting->increment('sortOrder');

        $meeting->save();

        $sessionId = $meeting->id;

        $input = $request->all();

        $condition = $input['title'];

        foreach ($condition as $key => $condition) {
      
        $combo[] = [
             'title' => $input['title'][$key],
             'description' => $input['descriptions'][$key],
             'sessionId' => $sessionId,
             'status' => 1,
             'sortOrder' => 1,
        ];
      }
       SessionContant::insert($combo);

        return redirect()->route('meeting.index')->with('message', 'Meeting Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function meetingActivate($id)
    {  

         $data['meeting'] = Meeting::find($id);

         $programId = $data['meeting']->programId;
         $subjectId = $data['meeting']->subjectId;
         $date = $data['meeting']->date;
         $timeSlotId = $data['meeting']->timeSlotId;

        //Getting Teacher Studying on coming Slot And Time

        $teacherDoingJob = Meeting::where('date', $date)->where('timeSlotId', $timeSlotId)->whereNotNull('tutorId')->pluck('tutorId')->toArray();

        //dd($teacherDoingJob);

       //print_r(count($teacherDoingJob));die();

        //Getting List Of Teacher for coming program and subject 
        
        $data['teacher'] = TeacherClass::where('programId',$programId)->where('subjectId',$subjectId)
        ->whereNotIn('teacherId', $teacherDoingJob)
        ->get();

        //dd($data['teacher'] );

        // dd($data['teacher']);

        $data["pageTitle"] = 'Activate Meeting';
        $data["activeMenu"] = 'meeting';
      
         return view('admin.meeting.activate')->with($data);
    }
    
    public function meetingActivateUpdate(Request $request)
    {
        
        $id = $request->input('id');
        $tutorId = $request->input('tutorId');

        $meeting = Meeting::find($id);

        $date = $meeting['date'];
        $timeSlotId = $meeting['timeSlotId'];

        $recordData = $this->checkUniqueScheduleForTeacher($date, $timeSlotId, $tutorId);

         if($recordData){

            return redirect('/admin/meeting/activate/'.$id)->with('message', 'Teacher Timings are already scheduled for another session');
            die();

         }

        $meeting->meetingUrl = $request->input('meetingUrl');
        $meeting->meetingStatus = $request->input('meetingStatus');

        if($request->filled('tutorId')) {

            $meeting->tutorId = $request->input('tutorId');
          
            }
        
        

        $meeting->save();

        if($request->filled('tutorId')) {

          
            
            Mail::send('emails.meetingRegesterd',  ['meeting' =>  $meeting], function ($m){
                $m->from('hello@app.com', 'Your Application');
                
                $m->to(['priyank@optimalvirtualemployee.com'])->subject('Meeting Registered with student!');
            }); 
            }

        return redirect()->route('meeting.index')->with('message', 'meeting Activated Successfully');
    }

    public function checkUniqueScheduleForTeacher($date, $timeSlotId, $tutorId)
    {
        $meeting = Meeting::where('date', $date)->where('timeSlotId', $timeSlotId)->where('tutorId', $tutorId)->first();

        return $meeting;
    }

    public function edit($id)
    {
        
        $data = array();

        $data['meeting'] = Meeting::find($id);
        $data['sessionContent'] = SessionContant::where('sessionId',$id)->orderBy('sortOrder')->get();
        $data["questionCategory"] = QuestionCategory::orderBy('id')->get();
        $data["program"] = Program::where('status',1)->orderBy('sortOrder')->get();
        $data["subject"] = Subject::orderBy('sortOrder')->get();
        $data["topic"] = Topic::orderBy('sortOrder')->get();
        $data["tutorId"] = User::where('roleId',2)->orderBy('sortOrder')->get();
        $data["sessionRecieverId"] = User::Where('roleId','4')->where('status',1)->orderBy('sortOrder')->get();
        $data["state"] = States::orderBy('sortOrder')->get();
        $data["timeSlot"] = TimeSlot::where('status',1)->orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Meeting';
        $data["activeMenu"] = 'meeting';
        return view('admin.meeting.create')->with($data);
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


        // $this->validate(request(), [
        //     'practiceSetQuestionId' => 'required',
        //     'description' => 'required',
        // ]);
        
        $id = $request->input('id');

        $meeting = Meeting::find($id);

         // Image Uploading

         // if ($request->hasFile('image')) {  // Check if file input is set

         //    $mediaId = imageUpload($request->image, $meeting->imageId, $this->userId, "uploads/meeting/"); //Image, ReferenceRecordId, UserId, Path
            
         //    $meeting->imageId = $mediaId;
 
         // }

        if ($request->hasFile('pdf')) {  // Check if file input is set

            $mediaPdfId = imageUpload($request->pdf, $meeting->pdfId, $this->userId, "uploads/meeting/");
            
            $meeting->pdfId = $mediaPdfId;
 
         }
         
        // $meeting->programId = $request->input('programId');
        // $meeting->subjectId = $request->input('subjectId');
        // $meeting->topicId = $request->input('topicId');
        // $meeting->tutorId = $request->input('tutorId');
        // $meeting->sessionRecieverId = $request->input('sessionRecieverId');
        // $meeting->stateId = $request->input('stateId');
        // $meeting->date = $request->input('date');
        // $meeting->timeSlotId = $request->input('timeSlotId');
        // $meeting->name = $request->input('name');
        $meeting->description = $request->input('description');
        $meeting->practiceSetQuestionId = $request->input('practiceSetQuestionId');

        $meeting->save();

        // Inserting Session Content Data

        $insertedId = $meeting->id;

        $title = $request->input('title');
        $sessionContentId = $request->input('sessionContentId');
        $descriptions = $request->input('descriptions');

        // Deleting extra entries

        if(empty($sessionContentId)){

            $sessionContentId = array();
        }

        $del = SessionContant::where('sessionId', $insertedId)->whereNotIn('id', $sessionContentId)->delete();
      
        $i=0;

        if(isset($title)){
        
        foreach ($title as $value) {

        
           if(isset($sessionContentId[$i]) && !empty($sessionContentId[$i])){

            //update this record
            
            $scId = $sessionContentId[$i];
            $sessionContent = SessionContant::find($scId);
           

           }else{

            //insert this record

            $sessionContent = new SessionContant();
            $sessionContent->status = 1;
            $sessionContent->sortOrder = 1;
            $sessionContent->sessionId = $insertedId;
            
           }


           $sessionContent->title = $title[$i];
           $sessionContent->description = $descriptions[$i];   
           $sessionContent->save();

        $i++;}}

        // Inserting Session Content Data



        return redirect()->route('meeting.index')->with('message', 'Meeting Updated Successfully');
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
        $meeting = Meeting::find($id);
        $meeting->delete($id);

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
                $meeting = Meeting::find($id);
                $meeting->delete();
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
                $meeting = Meeting::find($id);
                $meeting->sortOrder = $values->position;
                $result = $meeting->save();
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

        $meeting = Meeting::find($id);
        $meeting->status = $status;
        $result = $meeting->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

    public function getTopicBySubjectId(Request $request)
    {
        $subjectId = $request->subjectId;
        $subject = Topic::where('subjectId', $subjectId)->where('status', 1)->get();

        $html = '<option value="">Select Topic</option>';

        foreach ($subject as $value) {
            $html .= "<option value='" . $value->id . "'>" . $value->title . "</option>";
        }

        if (!empty($html)) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => $html);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

        public function getTeacherByProgramIDSubjectId(Request $request)
    {
        $programId = $request->programId;
        

        $subject = TeacherClass::where('programId', $programId)->first();

        $subjectId = $subject->subjectId;

        $subject = TeacherClass::where('programId', $programId)->where('subjectId', $subjectId)->get();

        $html = '<option value="">Select Teacher</option>';

        foreach ($subject as $value) {
            $html .= "<option value='" . $value->teacher->id . "'>" . $value->teacher->name . "</option>";
        }

        if (!empty($html)) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => $html);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}