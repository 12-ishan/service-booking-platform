<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BloodGroup;
use Illuminate\Support\Facades\Auth;


class BloodGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisationId = Auth::user()->organisationId;    
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
        $data["bloodGroup"] = BloodGroup::where('organisationId', $this->organisationId)->orderBy('sortOrder')->get(); 
        $data["pageTitle"] = 'Manage Blood Group';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'bloodGroup';
        return view('admin.bloodGroup.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data["pageTitle"] = 'Add Blood Group';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'bloodGroup';
        return view('admin.bloodGroup.create')->with($data);
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

        $bloodGroup = new BloodGroup();
        $bloodGroup->name = $request->input('name');
        $bloodGroup->description = $request->input('description');
        $bloodGroup->status = 1;
        $bloodGroup->sortOrder = 1;
        $bloodGroup->increment('sortOrder');
        $bloodGroup->save();
        return redirect()->route('bloodGroup.index')->with('message', 'Blood group Added Successfully');
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
        $data['bloodGroup'] = BloodGroup::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Blood Group';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'bloodGroup';
        return view('admin.bloodGroup.create')->with($data);
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
        $bloodGroup = BloodGroup::find($id);
        $bloodGroup->name = $request->input('name');
        $bloodGroup->description = $request->input('description');
        $bloodGroup->save();
        return redirect()->route('bloodGroup.index')->with('message', 'Blood group Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $bloodGroup = BloodGroup::find($id);
        $bloodGroup->delete($id);
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
                $bloodGroup = BloodGroup::find($id);
                $bloodGroup->delete();
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
                $bloodGroup = BloodGroup::find($id);
                $bloodGroup->sortOrder = $values->position;
                $result = $bloodGroup->save();
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
        $bloodGroup = BloodGroup::find($id);
        $bloodGroup->status = $status;
        $result = $bloodGroup->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}



