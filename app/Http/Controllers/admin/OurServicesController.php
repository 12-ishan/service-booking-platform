<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\OurServices;
use Illuminate\Support\Facades\Auth;


class OurServicesController extends Controller
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

        $data["ourServices"] = OurServices::orderBy('sortOrder')->get();
      
        $data["pageTitle"] = 'Manage Services';
        $data["activeMenu"] = 'ourServices';
        return view('admin.ourServices.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Services';
        $data["activeMenu"] = 'ourServices';
        return view('admin.ourServices.create')->with($data);
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
            'title' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required'
        ]);

        $ourServices = new OurServices();

        if ($request->hasFile('image')) {  

            $mediaId = imageUpload($request->image, $ourServices->imageId, $this->userId, "uploads/services/"); 
           
            $ourServices->imageId = $mediaId;
 
         }

        $ourServices->title = $request->input('title');
        $ourServices->description = $request->input('description');
       
        $ourServices->status = 1;
        $ourServices->sortOrder = 1;

        $ourServices->increment('sortOrder');

        $ourServices->save();

        return redirect()->route('our-services.index')->with('message', 'our Services Added Successfully');
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

        $data['ourServices'] = OurServices::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Our Services';
        $data["activeMenu"] = 'ourServices';
        return view('admin.ourServices.create')->with($data);
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
            'title' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required'
        ]);
        
        $id = $request->input('id');

        $ourServices = OurServices::find($id);

        if ($request->hasFile('image')) {  

            $mediaId = imageUpload($request->image, $ourServices->imageId, $this->userId, "uploads/services/"); 
            
            $ourServices->imageId = $mediaId;
 
         }

        $ourServices->title = $request->input('title');
        $ourServices->description = $request->input('description');

        $ourServices->save();

        return redirect()->route('our-services.index')->with('message', 'our Services Updated Successfully');
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
        $ourServices = OurServices::find($id);
        $ourServices->delete($id);

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
                $ourServices = OurServices::find($id);
                $ourServices->delete();
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
                $ourServices = OurServices::find($id);
                $ourServices->sortOrder = $values->position;
                $result = $ourServices->save();
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

        $ourServices = OurServices::find($id);
        $ourServices->status = $status;
        $result = $ourServices->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
