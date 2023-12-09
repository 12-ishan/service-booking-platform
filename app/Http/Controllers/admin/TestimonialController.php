<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Testimonial;
use Illuminate\Support\Facades\Auth;


class TestimonialController extends Controller
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

        $data["testimonial"] = Testimonial::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage Testimonial';
        $data["activeMenu"] = 'website-management';
        $data["activeSubMenu"] = 'testimonial';
        return view('admin.testimonial.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Testimonial';
        $data["activeMenu"] = 'website-management';
        $data["activeSubMenu"] = 'testimonial';
        return view('admin.testimonial.create')->with($data);
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $testimonial = new Testimonial();

        // Image Uploading

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $testimonial->imageId, $this->userId, "uploads/testimonial/"); //Image, ReferenceRecordId, UserId, Path
            
            $testimonial->imageId = $mediaId;
 
         }

            $testimonial->name = $request->input('name');
            $testimonial->designation = $request->input('designation');
            $testimonial->description = $request->input('description');
       
        $testimonial->status = 1;
        $testimonial->sortOrder = 1;

        $testimonial->increment('sortOrder');

        $testimonial->save();

        return redirect()->route('testimonial.index')->with('message', 'Testimonial Added Successfully');
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

        $data['testimonial'] = Testimonial::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Testimonial';
        $data["activeMenu"] = 'website-management';
        $data["activeSubMenu"] = 'testimonial';
        return view('admin.testimonial.create')->with($data);
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

        $testimonial = Testimonial::find($id);

         // Image Uploading

         if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $testimonial->imageId, $this->userId, "uploads/testimonial/"); //Image, ReferenceRecordId, UserId, Path
            
            $testimonial->imageId = $mediaId;
 
         }

        $testimonial->name = $request->input('name');
        $testimonial->designation = $request->input('designation');
        $testimonial->description = $request->input('description');
        $testimonial->save();
        return redirect()->route('testimonial.index')->with('message', 'Testimonial Updated Successfully');
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
        $testimonial = Testimonial::find($id);
        $testimonial->delete($id);

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
                $testimonial = Testimonial::find($id);
                $testimonial->delete();
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
                $testimonial = Testimonial::find($id);
                $testimonial->sortOrder = $values->position;
                $result = $testimonial->save();
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

        $testimonial = Testimonial::find($id);
        $testimonial->status = $status;
        $result = $testimonial->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
