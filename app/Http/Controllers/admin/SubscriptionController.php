<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Subscription;
use Illuminate\Support\Facades\Auth;


class SubscriptionController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();

        $data["subscription"] = Subscription::orderBy('sortOrder')->get();
      

        $data["pageTitle"] = 'Manage Subscription';
        $data["activeMenu"] = 'subscription';
        return view('admin.subscription.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Subscription';
        $data["activeMenu"] = 'subscription';
        return view('admin.subscription.create')->with($data);
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
            'days' => 'required',
            'noOfSubjects' => 'required',
            'noOfClasses' => 'required',
            'amount' => 'required',
        ]);

        $subscription = new Subscription();

        $subscription->name = $request->input('name');
        $subscription->days = str_slug($request->input('days'));
        $subscription->noOfSubjects = $request->input('noOfSubjects');
        $subscription->noOfClasses = $request->input('noOfClasses');
        $subscription->amount = $request->input('amount');
       
        $subscription->status = 1;
        $subscription->sortOrder = 1;

        $subscription->increment('sortOrder');

        $subscription->save();

        return redirect()->route('subscription.index')->with('message', 'Subscription Added Successfully');
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

        $data['subscription'] = Subscription::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Subscription';
        $data["activeMenu"] = 'subscription';
        return view('admin.subscription.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required',
            'days' => 'required',
            'noOfSubjects' => 'required',
            'noOfClasses' => 'required',
            'amount' => 'required',
        ]);
        
        $id = $request->input('id');

        $subscription = Subscription::find($id);

        $subscription->name = $request->input('name');
        $subscription->days = str_slug($request->input('days'));
        $subscription->noOfSubjects = $request->input('noOfSubjects');
        $subscription->noOfClasses = $request->input('noOfClasses');
        $subscription->amount = $request->input('amount');

        $subscription->save();

        return redirect()->route('subscription.index')->with('message', 'Subscription Updated Successfully');
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
        $subscription = Subscription::find($id);
        $subscription->delete($id);

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
                $subscription = Subscription::find($id);
                $subscription->delete();
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
                $subscription = Subscription::find($id);
                $subscription->sortOrder = $values->position;
                $result = $subscription->save();
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

        $subscription = Subscription::find($id);
        $subscription->status = $status;
        $result = $subscription->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
