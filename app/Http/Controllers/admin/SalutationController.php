<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Salutation;
use Illuminate\Support\Facades\Auth;

class SalutationController extends Controller
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
        $data["salutation"] = Salutation::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage salutation';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'salutation';
        return view('admin.salutation.manage')->with($data);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add Salutation';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'salutation';
        return view('admin.salutation.create')->with($data);
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

        $salutation = new Salutation();
        $salutation->name = $request->input('name');
        $salutation->description = $request->input('description');
        $salutation->status = 1;
        $salutation->sort_order = 1;
        $salutation->increment('sort_order');
        $salutation->save();
        return redirect()->route('salutation.index')->with('message', 'Salutation Added Successfully');
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
        $data['salutation'] = Salutation::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate Salutation";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'salutation';
        return view('admin.salutation.create')->with($data);
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
        $salutation = Salutation::find($id);
        $salutation->name = $request->input('name');
        $salutation->description = $request->input('description');
        $salutation->save();
        return redirect()->route('salutation.index')->with('message', 'Salutation Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $salutation = Salutation::find($id);
        $salutation->delete($id);
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
                $salutation = Salutation::find($id);
                $salutation->delete();
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
                $salutation = Salutation::find($id);
                $salutation->sort_order = $values->position;
                $result = $salutation->save();
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
        $salutation = Salutation::find($id);
        $salutation->status = $status;
        $result = $salutation->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }

}





