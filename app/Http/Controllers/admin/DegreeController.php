<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Degree;
use Illuminate\Support\Facades\Auth;

class DegreeController extends Controller
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
        $data["degree"] = Degree::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage Degree';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'degree';
        return view('admin.degree.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add Degree';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'degree';
        return view('admin.degree.create')->with($data);   
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

        $degree = new Degree();
        $degree->name = $request->input('name');
        $degree->description = $request->input('description');
        $degree->status = 1;
        $degree->sort_order = 1;
        $degree->increment('sort_order');
        $degree->save();
        return redirect()->route('degree.index')->with('message', 'Degree Added Successfully');
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
        $data['degree'] = Degree::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate Degree";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'degree';
        return view('admin.degree.create')->with($data);
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
        $degree = Degree::find($id);
        $degree->name = $request->input('name');
        $degree->description = $request->input('description');
        $degree->save();
        return redirect()->route('degree.index')->with('message', 'Degree Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $degree = Degree::find($id);
        $degree->delete($id);
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
                $degree = Degree::find($id);
                $degree->delete();
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
                $degree = Degree::find($id);
                $degree->sort_order = $values->position;
                $result = $degree->save();
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
        $degree = Degree::find($id);
        $degree->status = $status;
        $result = $degree->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }

}


