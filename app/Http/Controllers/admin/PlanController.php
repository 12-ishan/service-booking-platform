<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Plan;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Program;
use App\Model\Admin\Subject;
use App\Model\Admin\Topic;


class PlanController extends Controller
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

        $data["plan"] = Program::select(
            "subject.name as subjectName", 
            "program.name as programName",
            "program.id as programId",
            "subject.id as subjectId"
        )->rightJoin("subject", "subject.programId", "=", "program.id")->get();
       
        $data["pageTitle"] = 'Manage Plans';
        $data["activeMenu"] = 'plan';
        return view('admin.plan.manage')->with($data);
    }


    public function topic($programId, $subjectId)
    {   
        $data = array();

        $data["topic"] = Topic::where('programId', $programId)->where('subjectId', $subjectId)->orderBy('sortOrder')->get();

        $data["plan"] = Plan::where('programId', $programId)->where('subjectId', $subjectId)->orderBy('sortOrder')->get();

         $data["programId"] = $programId;
         $data["subjectId"] = $subjectId;

         $data["pageTitle"] = 'Manage Topics';
         $data["activeMenu"] = 'plan';
        return view('admin.plan.topic')->with($data);
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
            'topicId' => 'required',
            'amount' => 'required',
            'quantity' => 'required|unique:plan,quantity,NULL,id,topicId,' . $request->topicId,
        ],
        [
            'topicId.required'=> 'Please select topic',
            'quantity.required'=> 'Please enter quantity',
            'quantity.unique'=> 'Entered plan already exists',
            'amount.required'=> 'Please enter amount',
        ]
    );


        $programId = $request->input('programId');
        $subjectId = $request->input('subjectId');

        $plan = new Plan();

        $plan->programId = $programId;
        $plan->subjectId = $subjectId;
        $plan->topicId = $request->input('topicId');
        $plan->quantity = $request->input('quantity');
        $plan->amount = $request->input('amount');

       
        $plan->status = 1;
        $plan->sortOrder = 1;

        $plan->increment('sortOrder');

        $plan->save();

        return redirect()->route('plan.topic',['programId' => $programId, 'subjectId' => $subjectId])->with('message', 'Plan Added Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

        $id = $request->id;
        $programId = $request->input('programId');
        $subjectId = $request->input('subjectId');

        $plan = Plan::find($id);
        $plan->delete($id);

        return redirect()->route('plan.topic',['programId' => $programId, 'subjectId' => $subjectId])->with('message', 'Plan Delete Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
        
    //     $data = array();

    //     $data['banner'] = Banner::find($id);

    //     $data["editStatus"] = 1;
    //     $data["pageTitle"] = 'Update Banner';
    //     $data["activeMenu"] = 'banner';
    //     return view('admin.banner.create')->with($data);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request)
    // {

    //     $this->validate(request(), [
    //         'type' => 'required',
    //         'bannerHeading' => 'required',
    //         'bannerText' => 'required',
    //         'bannerSloganText' => 'required',
    //         'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ],
    //     [
    //         'type.required'=> 'Banner type is required',
    //         'bannerHeading.required'=> 'Banner heading is required',
    //         'bannerText.required'=> 'Banner text is required',
    //         'bannerSloganText.required'=> 'Banner slogan text is required',
    //         'image'=> 'Banner image formate jpeg,png,jpg,gif,svg|max:2048',

    //     ]);
        
    //     $id = $request->input('id');
 
    //     $banner = Banner::find($id);

    //      // Image Uploading

    //      if ($request->hasFile('image')) {  // Check if file input is set

    //         $mediaId = imageUpload($request->image, $banner->imageId, $this->userId, "uploads/banner/"); //Image, ReferenceRecordId, UserId, Path
            
    //         $banner->imageId = $mediaId;
 
    //      }

    //     $banner->type = $request->input('type');
    //     $banner->bannerHeading = $request->input('bannerHeading');
    //     $banner->bannerText = $request->input('bannerText');
    //     $banner->bannerSloganText = $request->input('bannerSloganText');

    //     $banner->save();

    //     return redirect()->route('banner.index')->with('message', 'Banner Updated Successfully');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Request $request)
    // {
    //     $id = $request->id;
    //     $banner = Banner::find($id);
    //     $banner->delete($id);

    //     return response()->json([
    //         'status' => 1,
    //         'message' => 'Delete Successfull',
    //         'response' => $request->id
    //     ]);
    // }

    /**
     * Remove all selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function destroyAll(Request $request)
    // {

    //     $record = $request->input('deleterecords');

    //     if (isset($record) && !empty($record)) {

    //         foreach ($record as $id) {
    //             $banner = Banner::find($id);
    //             $banner->delete();
    //         }
    //     }

    //     return response()->json([
    //         'status' => 1,
    //         'message' => 'Delete Successfull',
    //         'response' => ''
    //     ]);
    // }

    /**
     * Update SortOrder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function updateSortorder(Request $request)
    // {
    //     $data = $request->records;
    //     $decoded_data = json_decode($data);
    //     $result = 0;

    //     if (is_array($decoded_data)) {
    //         foreach ($decoded_data as $values) {

    //             $id = $values->id;
    //             $banner = Banner::find($id);
    //             $banner->sortOrder = $values->position;
    //             $result = $banner->save();
    //         }
    //     }

    //     if ($result) {
    //         $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
    //     } else {
    //         $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
    //     }

    //     return response()->json($response);
    // }

    /**
     * Update Status resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function updateStatus(Request $request)
    // {
    //     $status = $request->status;
    //     $id = $request->id;

    //     $banner = Banner::find($id);
    //     $banner->status = $status;
    //     $result = $banner->save();

    //     if ($result) {
    //         $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
    //     } else {
    //         $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
    //     }

    //     return response()->json($response);
    // }

}