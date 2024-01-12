<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Mode;
use Illuminate\Support\Facades\Auth;

class ModeController extends Controller
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
        $data["mode"] = Mode::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage Mode';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'mode';
        return view('admin.mode.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add Mode';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'mode';
        return view('admin.mode.create')->with($data); 
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

        $mode = new Mode();
        $mode->name = $request->input('name');
        $mode->description = $request->input('description');
        $mode->status = 1;
        $mode->sort_order = 1;
        $mode->increment('sort_order');
        $mode->save();
        return redirect()->route('mode.index')->with('message', 'Mode Added Successfully');
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
    public function edit($id)
    {
        //
         $data = array();
         $data['mode'] = Mode::find($id);
         $data["editStatus"] = 1;
         $data['pageTitle'] = "Upadate Mode";
         $data['activeMenu'] = 'master';
         $data['activeSubMenu'] = 'mode';
         return view('admin.mode.create')->with($data);
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
        $mode = Mode::find($id);
        $mode->name = $request->input('name');
        $mode->description = $request->input('description');
        $mode->save();
        return redirect()->route('mode.index')->with('message', 'Mode Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $mode = Mode::find($id);
        $mode->delete($id);
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
                $mode = Mode::find($id);
                $mode->delete();
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
                $mode = Mode::find($id);
                $mode->sort_order = $values->position;
                $result = $mode->save();
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
        $mode = Mode::find($id);
        $mode->status = $status;
        $result = $mode->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }

}




