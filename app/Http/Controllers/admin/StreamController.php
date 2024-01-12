<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Stream;
use Illuminate\Support\Facades\Auth;

class StreamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisation_id = Auth::user()->organisation_id;    
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = array();
        $data["stream"] = Stream::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage stream';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'stream';
        return view('admin.stream.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add Stream';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'stream';
        return view('admin.stream.create')->with($data);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $stream = new Stream();
        $stream->name = $request->input('name');
        $stream->description = $request->input('description');
        $stream->status = 1;
        $stream->sort_order = 1;
        $stream->increment('sort_order');
        $stream->save();
        return redirect()->route('stream.index')->with('message', 'Stream Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = array();
        $data['stream'] = Stream::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate Stream";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'stream';
        return view('admin.stream.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $this->validate(request(), [
            'name' => 'required',
        ]);
        $id = $request->input('id');
        $stream = Stream::find($id);
        $stream->name = $request->input('name');
        $stream->description = $request->input('description');
        $stream->save();
        return redirect()->route('stream.index')->with('message', 'Stream Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $stream = Stream::find($id);
        $stream->delete($id);
        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }

    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');
        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $stream = Stream::find($id);
                $stream->delete();
            }
        }
        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }

    public function updateSortorder(Request $request)
    {
        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;
        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $stream = Stream::find($id);
                $stream->sort_order = $values->position;
                $result = $stream->save();
            }
        }
        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }
        return response()->json($response);
    }

    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        $stream = Stream::find($id);
        $stream->status = $status;
        $result = $stream->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}





