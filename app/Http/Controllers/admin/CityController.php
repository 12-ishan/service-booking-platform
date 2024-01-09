<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\City;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
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
        $data["city"] = City::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage city';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'city';
        return view('admin.city.manage')->with($data);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add City';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'city';
         return view('admin.city.create')->with($data);
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

        $city = new City();
        $city->name = $request->input('name');
        $city->description = $request->input('description');
        $city->status = 1;
        $city->sort_order = 1;
        $city->increment('sort_order');
        $city->save();
        return redirect()->route('city.index')->with('message', 'City Added Successfully');
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
        $data['city'] = City::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate City";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'city';
        return view('admin.city.create')->with($data);
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
        $city = City::find($id);
        $city->name = $request->input('name');
        $city->description = $request->input('description');
        $city->save();
        return redirect()->route('city.index')->with('message', 'City Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $city = City::find($id);
        $city->delete($id);
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
                $city = City::find($id);
                $city->delete();
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
                $city = City::find($id);
                $city->sort_order = $values->position;
                $result = $city->save();
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
        $city = City::find($id);
        $city->status = $status;
        $result = $city->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}

