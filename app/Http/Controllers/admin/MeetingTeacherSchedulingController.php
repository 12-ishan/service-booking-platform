<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\MeetingTeacherScheduling;
use App\Model\Admin\Meeting;
use App\Model\Admin\User;
use App\Model\Admin\Role;
use Illuminate\Support\Facades\Auth;


class MeetingTeacherSchedulingController extends Controller
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

        $data["meetingTeacherScheduling"]= MeetingTeacherScheduling::selectRaw('meeting_teacher_scheduling.*,users.name as teachername,meeting.name as meetingname')
                ->leftJoin('users','users.id','=','meeting_teacher_scheduling.teacherId')
                ->leftJoin('meeting','meeting.id','=','meeting_teacher_scheduling.meetingId')
                ->orderBy('meeting_teacher_scheduling.id','asc')
                ->get();

        $data["pageTitle"] = 'Manage Meeting Teacher Scheduling';
        $data["activeMenu"] = 'meeting-teacher-scheduling';
        return view('admin.meetingTeacherScheduling.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["meetingList"] = Meeting::orderBy('sortOrder')->get();
        $data["role"] = User::where('roleId',2)->orderBy('id')->get();

        $data["pageTitle"] = 'Add Meeting Teacher Scheduling';
        $data["activeMenu"] = 'meeting-teacher-scheduling';
        return view('admin.meetingTeacherScheduling.create')->with($data);
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
                'meetingId' => 'required',
                'teacherId' => 'required',
                'meetingDate' => 'date_format:Y-m-d|required|unique:meeting_teacher_scheduling',
                'meetingTime' => 'date_format:H:i|required|unique:meeting_teacher_scheduling',
        ]);

        $meetingTeacherScheduling = new MeetingTeacherScheduling();

            $meetingTeacherScheduling->meetingId = $request->input('meetingId');
            $meetingTeacherScheduling->teacherId = $request->input('teacherId');
            $meetingTeacherScheduling->meetingDate = $request->input('meetingDate');
            $meetingTeacherScheduling->meetingTime = $request->input('meetingTime');
       
        $meetingTeacherScheduling->status = 1;
        $meetingTeacherScheduling->sortOrder = 1;

        $meetingTeacherScheduling->increment('sortOrder');

        $meetingTeacherScheduling->save();

        return redirect()->route('meeting-teacher-scheduling.index')->with('message', 'Meeting Teacher Scheduling Added Successfully');
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

        $data['meetingTeacherScheduling'] = MeetingTeacherScheduling::find($id);

        $data["meetingList"] = Meeting::orderBy('sortOrder')->get();
        $data["role"] = User::where('roleId',2)->orderBy('id')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Meeting Teacher Scheduling';
        $data["activeMenu"] = 'meeting-teacher-scheduling';
        return view('admin.meetingTeacherScheduling.create')->with($data);
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
                'meetingId' => 'required',
                'teacherId' => 'required',
                'meetingDate' => 'required',
                'meetingTime' => 'required',
        ]);
        
        $id = $request->input('id');

        $meetingTeacherScheduling = MeetingTeacherScheduling::find($id);


        $meetingTeacherScheduling->meetingId = $request->input('meetingId');
        $meetingTeacherScheduling->teacherId = $request->input('teacherId');
        $meetingTeacherScheduling->meetingDate = $request->input('meetingDate');
        $meetingTeacherScheduling->meetingTime = $request->input('meetingTime');

        $meetingTeacherScheduling->save();

        return redirect()->route('meeting-teacher-scheduling.index')->with('message', 'Meeting Teacher Scheduling Updated Successfully');
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
        $meetingTeacherScheduling = MeetingTeacherScheduling::find($id);
        $meetingTeacherScheduling->delete($id);

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
                $meetingTeacherScheduling = MeetingTeacherScheduling::find($id);
                $meetingTeacherScheduling->delete();
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
                $meetingTeacherScheduling = MeetingTeacherScheduling::find($id);
                $meetingTeacherScheduling->sortOrder = $values->position;
                $result = $meetingTeacherScheduling->save();
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

        $meetingTeacherScheduling = MeetingTeacherScheduling::find($id);
        $meetingTeacherScheduling->status = $status;
        $result = $meetingTeacherScheduling->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
