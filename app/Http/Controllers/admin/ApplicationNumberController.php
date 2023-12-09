<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\ApplicationNumber;


class ApplicationNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();

        $data["applicationNumber"] = ApplicationNumber::orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Manage Application Number';
        $data["activeMenu"] = 'general';
        $data["activeSubMenu"] = 'applicationNumber';
        return view('admin.applicationNumber.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Application Number';
        $data["activeMenu"] = 'general';
        $data["activeSubMenu"] = 'applicationNumber';
        return view('admin.applicationNumber.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'type' => 'required',
        ]);

        $applicationNumber = new ApplicationNumber();

        $applicationNumber->prefix = $request->input('prefix');
        $applicationNumber->suffix = $request->input('suffix');
        $applicationNumber->startNumber = $request->input('startNumber');
        $applicationNumber->type = $request->input('type');
        $applicationNumber->comment = $request->input('comment');
        $applicationNumber->status = 1;
        $applicationNumber->sortOrder = 1;

        $applicationNumber->increment('sortOrder');

        $applicationNumber->save();

        return redirect()->route('application-number.index')->with('message', 'Application Number Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = array();

        $data['applicationNumber'] = ApplicationNumber::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Application Number';
        $data["activeMenu"] = 'general';
        $data["activeSubMenu"] = 'applicationNumber';
        return view('admin.applicationNumber.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'type' => 'required',
        ]);


        $applicationNumber = ApplicationNumber::find($id);

        $applicationNumber->prefix = $request->input('prefix');
        $applicationNumber->suffix = $request->input('suffix');
        $applicationNumber->startNumber = $request->input('startNumber');
        $applicationNumber->type = $request->input('type');
        $applicationNumber->comment = $request->input('comment');

        $applicationNumber->save();

        return redirect()->route('application-number.index')->with('message', 'Application Number Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $applicationNumber = ApplicationNumber::find($id);
        $applicationNumber->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }

    /**
     * Remove all selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $applicationNumber = ApplicationNumber::find($id);
                $applicationNumber->delete();
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }

    /**
     * Update SortOrder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSortorder(Request $request)
    {
        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;

        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $applicationNumber = ApplicationNumber::find($id);
                $applicationNumber->sortOrder = $values->position;
                $result = $applicationNumber->save();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        $applicationNumber = ApplicationNumber::find($id);
        $applicationNumber->status = $status;
        $result = $applicationNumber->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }
}
