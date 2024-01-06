<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Gender;
use Illuminate\Support\Facades\Auth;

class GenderController extends Controller
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
        $data["gender"] = Gender::where('organisationId', $this->organisationId)->orderBy('sortOrder')->get(); //all();
        // echo "<pre>";
        // print_r($data);
        // die();

        $data["pageTitle"] = 'Manage Gender';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'gender';
        return view('admin.gender.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data["pageTitle"] = 'Add Gender';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'gender';
        return view('admin.gender.create')->with($data);

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

        $gender = new Gender();
        $gender->name = $request->input('name');
        $gender->description = $request->input('description');
        // echo "<pre>";
        // print_r($gender);
        // die();
        //$gender->organisationId = $this->organisationId;
        $gender->status = 1;
        $gender->sortOrder = 1;
        $gender->increment('sortOrder');
        $gender->save();
        return redirect()->route('gender.index')->with('message', 'Gender Added Successfully');
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
        $data['gender'] = Gender::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Gender';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'gender';
        return view('admin.gender.create')->with($data);
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
        $gender = Gender::find($id);
        $gender->name = $request->input('name');
        $gender->description = $request->input('description');
        $gender->save();
        return redirect()->route('gender.index')->with('message', 'Gender Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $gender = Gender::find($id);
        $gender->delete($id);
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
                $gender = Gender::find($id);
                $gender->delete();
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
                $gender = Gender::find($id);
                $gender->sortOrder = $values->position;
                $result = $gender->save();
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
        $gender = Gender::find($id);
        $gender->status = $status;
        $result = $gender->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}

