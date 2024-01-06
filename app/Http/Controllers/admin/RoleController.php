<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Role;
use App\Models\Admin\PermissionHead;
use App\Models\Admin\RolePermission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
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
        //
        $data = array();
        $data["role"] = Role::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage Role';
        $data["activeMenu"] = 'role';
        return view('admin.role.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data["permissionHead"] = PermissionHead::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Add Role';
        $data["activeMenu"] = 'role';
        return view('admin.role.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(), [
            'roleName' => 'required',
        ]);

        $permission = $request->input('permissions');
        $role = new Role();
        $role->roleName = $request->input('roleName');
        $role->status = 1;
        $role->sortOrder = 1;
        $role->increment('sortOrder');
        $role->save();

        $roleId = $role->id;
        foreach($permission as $value){

            $rolePermission = new RolePermission();
            $rolePermission->roleId = $roleId;
            $rolePermission->permissionId = $value;
            $rolePermission->save(); 
        }
        return redirect()->route('role.index')->with('message', 'Role Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
        $data['role'] = Role::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Role';
        $data["activeMenu"] = 'role';
        return view('admin.role.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        
        $this->validate(request(), [
            'roleName' => 'required',
        ]);
        
        $id = $request->input('id');

        $role = Role::find($id);

        $role->roleName = $request->input('roleName');
        $role->save();
        return redirect()->route('role.index')->with('message', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $role = Role::find($id);
        $role->delete($id);

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
                $role = Role::find($id);
                $role->delete();
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
                $role = Role::find($id);
                $role->sortOrder = $values->position;
                $result = $role->save();
            }
        }

        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }

        return response()->json($response);
    }

    /**
     * Update Status resource from storage.
     *
     */
    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        $role = Role::find($id);
        $role->status = $status;
        $result = $role->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}


