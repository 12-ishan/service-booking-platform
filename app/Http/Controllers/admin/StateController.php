<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\State;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
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
        $data["state"] = State::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage state';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'state';
        return view('admin.state.manage')->with($data);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add State';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'state';
        return view('admin.state.create')->with($data);   
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

        $state = new State();
        $state->name = $request->input('name');
        $state->description = $request->input('description');
        $state->status = 1;
        $state->sort_order = 1;
        $state->increment('sort_order');
        $state->save();
        return redirect()->route('state.index')->with('message', 'State Added Successfully');
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
        $data['state'] = State::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate State";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'state';
        return view('admin.state.create')->with($data);
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
        $state = State::find($id);
        $state->name = $request->input('name');
        $state->description = $request->input('description');
        $state->save();
        return redirect()->route('state.index')->with('message', 'State Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $state = State::find($id);
        $state->delete($id);
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
                $state = State::find($id);
                $state->delete();
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
                $state = State::find($id);
                $state->sort_order = $values->position;
                $result = $state->save();
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
        $state = State::find($id);
        $state->status = $status;
        $result = $state->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}



