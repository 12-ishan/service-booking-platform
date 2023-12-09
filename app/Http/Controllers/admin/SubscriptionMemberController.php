<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\SubscriptionMember;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\User;
use App\Model\Admin\Role;
use App\Model\Admin\Subscription;



class SubscriptionMemberController extends Controller
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

        $data["subscriptionMember"] = SubscriptionMember::orderBy('sortOrder')->get();
      

        $data["pageTitle"] = 'Manage Subscription Member';
        $data["activeMenu"] = 'subscription-member';
        return view('admin.subscriptionMember.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = array();

        $data["role"] = Role::whereIn('id', [3, 4])->get();
        $data["subscriptionId"] = Subscription::orderBy('id')->get();

        $data["pageTitle"] = 'Add Subscription Member';
        $data["activeMenu"] = 'subscription-member';
        return view('admin.subscriptionMember.create')->with($data);
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
            'userId' => 'required',
            'subscriptionId' => 'required',
        ]);

        $subscriptionMember = new SubscriptionMember();

        $days = Subscription::orderBy('sortOrder')->get();
        foreach ($days as $key => $value) {

        $date =date("Y-m-d");
        $day = $value->days;
        $expiryDate=date('Y-m-d', strtotime("+$day days"));
        }

        $subscriptionMember->userId = $request->input('userId');
        $subscriptionMember->subscriptionId = $request->input('subscriptionId');
        $subscriptionMember->expiryDate = $expiryDate;
       
        $subscriptionMember->status = 1;
        $subscriptionMember->sortOrder = 1;

        $subscriptionMember->increment('sortOrder');

        $subscriptionMember->save();

        return redirect()->route('subscription-member.index')->with('message', 'Subscription Member Added Successfully');
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
        
        $data['user'] = SubscriptionMember::find($id);
        $data["role"] = Role::whereIn('id', [3, 4])->get();

        $data['subscription'] = SubscriptionMember::find($id);
        $data["subscriptionId"] = Subscription::orderBy('id')->get();

        $data['subscriptionMember'] = SubscriptionMember::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Subscription Member';
        $data["activeMenu"] = 'subscription-mmber';
        return view('admin.subscriptionMember.create')->with($data);
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
            'userId' => 'required',
            'subscriptionId' => 'required',
        ]);
        
        $id = $request->input('id');

        $subscriptionMember = SubscriptionMember::find($id);

        $subscriptionMember = new SubscriptionMember();

        $days = Subscription::orderBy('sortOrder')->get();
        foreach ($days as $key => $value) {

        $date =date("Y-m-d");
        $day = $value->days;
        $expiryDate=date('Y-m-d', strtotime("+$day days"));
        }


    $subscriptionMember->userId = $request->input('userId');
    $subscriptionMember->subscriptionId = $request->input('subscriptionId');

        $subscriptionMember->save();

        return redirect()->route('subscription-member.index')->with('message', 'Subscription Member Updated Successfully');
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
        $subscriptionMember = SubscriptionMember::find($id);
        $subscriptionMember->delete($id);

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
                $subscriptionMember = SubscriptionMember::find($id);
                $subscriptionMember->delete();
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
                $subscriptionMember = SubscriptionMember::find($id);
                $subscriptionMember->sortOrder = $values->position;
                $result = $subscriptionMember->save();
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

        $subscriptionMember = SubscriptionMember::find($id);
        $subscriptionMember->status = $status;
        $result = $subscriptionMember->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
