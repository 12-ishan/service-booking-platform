<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ProficiencyLevel;
use Illuminate\Support\Facades\Auth;

class ProficiencyLevelController extends Controller
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
        $data["proficiencyLevel"] = ProficiencyLevel::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage Proficiency Level';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'proficiencyLevel';
        return view('admin.proficiencyLevel.manage')->with($data);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add Proficiency Level';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'proficiencyLevel';
        return view('admin.proficiencyLevel.create')->with($data);
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

        $proficiencyLevel = new ProficiencyLevel();
        $proficiencyLevel->name = $request->input('name');
        $proficiencyLevel->description = $request->input('description');
        $proficiencyLevel->status = 1;
        $proficiencyLevel->sort_order = 1;
        $proficiencyLevel->increment('sort_order');
        $proficiencyLevel->save();
        return redirect()->route('proficiencyLevel.index')->with('message', 'Proficiency Level Added Successfully');
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
        $data['proficiencyLevel'] = ProficiencyLevel::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate Proficiency Level";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'proficiencyLevel';
        return view('admin.proficiencyLevel.create')->with($data);
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
        $proficiencyLevel = ProficiencyLevel::find($id);
        $proficiencyLevel->name = $request->input('name');
        $proficiencyLevel->description = $request->input('description');
        $proficiencyLevel->save();
        return redirect()->route('proficiencyLevel.index')->with('message', 'Proficiency level Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $proficiencyLevel = ProficiencyLevel::find($id);
        $proficiencyLevel->delete($id);
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
                $proficiencyLevel = ProficiencyLevel::find($id);
                $proficiencyLevel->delete();
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
                $proficiencyLevel = ProficiencyLevel::find($id);
                $proficiencyLevel->sort_order = $values->position;
                $result = $proficiencyLevel->save();
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
        $proficiencyLevel = ProficiencyLevel::find($id);
        $proficiencyLevel->status = $status;
        $result = $proficiencyLevel->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}



