<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Meeting;
use App\Model\Admin\QuestionCategory;
use App\Model\Admin\SessionContant;
use App\Model\Admin\TeacherClass;
use App\Model\Admin\User;
use App\Model\Admin\Program;
use App\Model\Admin\Subject;
use App\Model\Admin\Topic;
use App\Model\Admin\States;
use App\Model\Admin\TimeSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DB;

class TeacherMeetingController extends Controller
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

        $data["pageTitle"] = 'Scheduled Meetings';
        $data["activeMenu"] = 'meeting';
        return view('admin.teacherMeeting.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data = array();

        $data['teacherMeeting'] = Meeting::find($id);
        $data['sessionContent'] = SessionContant::where('sessionId',$id)->orderBy('sortOrder')->get();
        $data["questionCategory"] = QuestionCategory::orderBy('id')->get();
        $data["program"] = Program::where('status',1)->orderBy('sortOrder')->get();
        $data["subject"] = Subject::orderBy('sortOrder')->get();
        $data["topic"] = Topic::orderBy('sortOrder')->get();
        $data["tutorId"] = User::where('roleId',2)->orderBy('sortOrder')->get();
        $data["state"] = States::orderBy('sortOrder')->get();
        $data["timeSlot"] = TimeSlot::where('status',1)->orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Teacher Meeting';
        $data["activeMenu"] = 'meeting';
        return view('admin.teacherMeeting.create')->with($data);
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
            'description' => 'required',
        ]);
        
        $id = $request->input('id');

        $meeting = Meeting::find($id);

         // Image Uploading

         if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $meeting->imageId, $this->userId, "uploads/meeting/"); //Image, ReferenceRecordId, UserId, Path
            
            $meeting->imageId = $mediaId;
 
         }

        if ($request->hasFile('pdf')) {  // Check if file input is set

            $mediaPdfId = imageUpload($request->pdf, $meeting->pdfId, $this->userId, "uploads/meeting/");
            
            $meeting->pdfId = $mediaPdfId;
 
         }
         
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

        return redirect()->route('teacher-meeting.index')->with('message', 'Meeting Updated Successfully');
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

        $data["pageTitle"] = 'Update Meeting';
        $data["activeMenu"] = 'meeting';
      
         return view('admin.teacherMeeting.activate')->with($data);
    }
    
    public function meetingActivateUpdate(Request $request)
    {
        
        $id = $request->input('id');
      

        $meeting = Meeting::find($id);

        $meeting->meetingStatus = $request->input('meetingStatus');
    
        $meeting->save();
        
        // if session is completed shoot a mail to student
        if($meeting->meetingStatus == 2){
            
            $user = User::where('id', $meeting->sessionRecieverId)->first();
            
            Mail::send('emails.sessionCompleted',  ['meeting' =>  $meeting], function ($m){
                $m->from('hello@app.com', 'Your Application');
                
                $m->to(['priyank@optimalvirtualemployee.com'])->subject('Upcoming Sesssion Information!');
            });
        }else if($meeting->meetingStatus == 3) {
            // if student fails to attend a session shoot a mail to student and admin
            $user = User::where('id', $meeting->sessionRecieverId)->first();
            
            Mail::send('emails.sessionMissed',  ['meeting' =>  $meeting], function ($m){
                $m->from('hello@app.com', 'Your Application');
                
                $m->to(['priyank@optimalvirtualemployee.com'])->subject('Upcoming Sesssion Information!');
            });
        }

        return redirect()->route('teacher-meeting.index')->with('message', 'mmeeting Updated Successfully');
    }
}