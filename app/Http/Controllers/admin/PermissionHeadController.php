<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PermissionHead;
use Illuminate\Support\Facades\Auth;

class PermissionHeadController extends Controller
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
     */
    public function index()
    {
        
        $data = array();
        $data["permissionHead"] = PermissionHead::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage Permission Head';
        $data["activeMenu"] = 'permissionHead';
        return view('admin.permissionHead.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data["pageTitle"] = 'Add Permission Head';
        $data["activeMenu"] = 'permissionHead';
        return view('admin.permissionHead.create')->with($data);
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

        $permissionHead = new PermissionHead();

        $permissionHead->name = $request->input('name');
        $permissionHead->status = 1;
        $permissionHead->sortOrder = 1;
        $permissionHead->increment('sortOrder');
        $permissionHead->save();
        return redirect()->route('permissionHead.index')->with('message', 'permissionHead Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
       

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $data = array();

        $data['permissionHead'] = PermissionHead::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Permission Head';
        $data["activeMenu"] = 'permissionHead';
        return view('admin.permissionHead.create')->with($data);
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

        $permissionHead = PermissionHead::find($id);
        $permissionHead->name = $request->input('name');
        $permissionHead->save();
        return redirect()->route('permissionHead.index')->with('message', 'Permission Head Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $permissionHead = PermissionHead::find($id);
        $permissionHead->delete($id);

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
                $permissionHead = PermissionHead::find($id);
                $permissionHead->delete();
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
                $permissionHead = PermissionHead::find($id);
                $permissionHead->sortOrder = $values->position;
                $result = $permissionHead->save();
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

        $permissionHead = PermissionHead::find($id);
        $permissionHead->status = $status;
        $result = $permissionHead->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
