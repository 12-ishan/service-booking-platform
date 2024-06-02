<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\BlogManager;
use App\Models\Admin\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class BlogManagerController extends Controller
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

        $data["blog"] = BlogManager::orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Manage Blog';
        $data["activeMenu"] = 'blog Manager';
        return view('admin.blogManager.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["category"] = BlogCategory::where('status',1)->orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Add blog';
        $data["activeMenu"] = 'blog Manager';
        return view('admin.blogManager.create')->with($data);
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
           
            
        ]);

        $blog = new BlogManager();

        if ($request->hasFile('image')) {  

            $mediaId = imageUpload($request->image, $blog->image_id, $this->userId, "uploads/blogImage/"); 
           
            $blog->image_id = $mediaId;
 
         }

        $blog->category_id = $request->input('categoryId');
        $blog->title = $request->input('title');
        $blog->slug = str::slug($request->input('title'));
        $blog->published_by = $request->input('publishedBy');
        $blog->published_on = $request->input('publishedDate');
        $blog->description = $request->input('description');
       
        $blog->status = 1;
        $blog->sortOrder = 1;

        $blog->increment('sortOrder');

        $blog->save();

        return redirect()->route('blog.index')->with('message', 'Blog Added Successfully');
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

        $data['blog'] = BlogManager::find($id);
        $data["category"] = BlogCategory::orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Blog';
        $data["activeMenu"] = 'blog Manager';
        return view('admin.blogManager.create')->with($data);
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
           
        ]);
        
        $id = $request->input('id');

        $blog = BlogManager::find($id);

        if ($request->hasFile('image')) {  

            $mediaId = imageUpload($request->image, $blog->image_id, $this->userId, "uploads/blogImage/"); 
            
            $blog->image_id = $mediaId;
 
         }

        $blog->category_id = $request->input('categoryId');
        $blog->title = $request->input('title');
        $blog->slug = urlencode($request->input('title'));
        $blog->published_by = $request->input('publishedBy');
        $blog->published_on = $request->input('publishedDate');
        $blog->description = $request->input('description');

        $blog->save();

        return redirect()->route('blog.index')->with('message', 'Blog Updated Successfully');
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
        $blog = BlogManager::find($id);
        $blog->delete($id);

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
                $blog = BlogManager::find($id);
                $blog->delete();
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
                $blog = BlogManager::find($id);
                $blog->sortOrder = $values->position;
                $result = $blog->save();
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

        $blog = BlogManager::find($id);
        $blog->status = $status;
        $result = $blog->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
