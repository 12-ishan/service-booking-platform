<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Page;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
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

        $data["page"] = Page::orderBy('sortOrder')->get();
      

        $data["pageTitle"] = 'Manage Page';
        $data["activeMenu"] = 'website-management';
        $data["activeSubMenu"] = 'page';
        return view('admin.page.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Page';
        $data["activeMenu"] = 'website-management';
        $data["activeSubMenu"] = 'page';
        return view('admin.page.create')->with($data);
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

        $page = new Page();

        // Image Uploading

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $page->imageId, $this->userId, "uploads/page/"); //Image, ReferenceRecordId, UserId, Path
            
            $page->imageId = $mediaId;
 
         }

            $page->name = $request->input('name');
            $page->slug = str_slug($request->input('name'));
            $page->metaKeyword = $request->input('metaKeyword');
            $page->metaDescription = $request->input('metaDescription');
            $page->description = $request->input('description');
       
        $page->status = 1;
        $page->sortOrder = 1;

        $page->increment('sortOrder');

        $page->save();

        return redirect()->route('page.index')->with('message', 'Page Added Successfully');
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

        $data['page'] = Page::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Page';
        $data["activeMenu"] = 'website-management';
        $data["activeSubMenu"] = 'page';
        return view('admin.page.create')->with($data);
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

        $page = Page::find($id);

         // Image Uploading

         if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $page->imageId, $this->userId, "uploads/page/"); //Image, ReferenceRecordId, UserId, Path
            
            $page->imageId = $mediaId;
 
         }

        $page->name = $request->input('name');
        $page->slug = str_slug($request->input('name'));
        $page->metaKeyword = $request->input('metaKeyword');
        $page->metaDescription = $request->input('metaDescription');
        $page->description = $request->input('description');

        $page->save();

        return redirect()->route('page.index')->with('message', 'Page Updated Successfully');
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
        $page = Page::find($id);
        $page->delete($id);

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
                $page = Page::find($id);
                $page->delete();
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
                $page = Page::find($id);
                $page->sortOrder = $values->position;
                $result = $page->save();
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

        $page = Page::find($id);
        $page->status = $status;
        $result = $page->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
