<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Promoter;
use App\Model\Admin\Country;


class PromoterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();

        $data["promoter"] = Promoter::orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Manage Promoter';
        $data["activeMenu"] = 'promoter';
        return view('admin.promoter.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["country"] = Country::orderBy('sortOrder')->get();

        //print_r($data["country"]);die();

        $data["pageTitle"] = 'Add Promoter';
        $data["activeMenu"] = 'promoter';
        return view('admin.promoter.create')->with($data);
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
            'name' => 'required',
            'email' => 'required',
        ]);

        $promoter = new Promoter();

        $promoter->name = $request->input('name');
        $promoter->contactPerson = $request->input('contactPerson');
        $promoter->weekendNumber = $request->input('weekendNumber');
        $promoter->address1 = $request->input('address1');
        $promoter->address2 = $request->input('address2');
        $promoter->zip = $request->input('zip');
        $promoter->town = $request->input('town');
        $promoter->location = $request->input('location');
        $promoter->countryId = $request->input('countryId');
        $promoter->localPhone = $request->input('localPhone');
        $promoter->cellPhone = $request->input('cellPhone');
        $promoter->email = $request->input('email');
        $promoter->website = $request->input('website');
        $promoter->capacity = $request->input('capacity');
        $promoter->genereOfMusic = $request->input('genereOfMusic');
        $promoter->priority = $request->input('priority');
        $promoter->comment = $request->input('comment');
        $promoter->status = 1;
        $promoter->sortOrder = 1;

        $promoter->increment('sortOrder');

        $promoter->save();

        return redirect()->route('promoter.index')->with('message', 'Promoter Added Successfully');
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

        $data['promoter'] = Promoter::find($id);

        $data["country"] = Country::orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Promoter';
        $data["activeMenu"] = 'promoter';
        return view('admin.promoter.create')->with($data);
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
            'name' => 'required',
            'email' => 'required',
        ]);


        $promoter = Promoter::find($id);

        $promoter->name = $request->input('name');
        $promoter->contactPerson = $request->input('contactPerson');
        $promoter->weekendNumber = $request->input('weekendNumber');
        $promoter->address1 = $request->input('address1');
        $promoter->address2 = $request->input('address2');
        $promoter->zip = $request->input('zip');
        $promoter->town = $request->input('town');
        $promoter->location = $request->input('location');
        $promoter->countryId = $request->input('countryId');
        $promoter->localPhone = $request->input('localPhone');
        $promoter->cellPhone = $request->input('cellPhone');
        $promoter->email = $request->input('email');
        $promoter->website = $request->input('website');
        $promoter->capacity = $request->input('capacity');
        $promoter->genereOfMusic = $request->input('genereOfMusic');
        $promoter->priority = $request->input('priority');
        $promoter->comment = $request->input('comment');
        
        $promoter->save();

        return redirect()->route('promoter.index')->with('message', 'Promoter Updated Successfully');
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
        $promoter = Promoter::find($id);
        $promoter->delete($id);

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
                $promoter = Promoter::find($id);
                $promoter->delete();
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
                $promoter = Promoter::find($id);
                $promoter->sortOrder = $values->position;
                $result = $promoter->save();
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

        $promoter = Promoter::find($id);
        $promoter->status = $status;
        $result = $promoter->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
