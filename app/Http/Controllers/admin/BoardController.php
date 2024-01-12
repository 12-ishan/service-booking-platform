<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Board;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
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
        $data["board"] = Board::where('organisation_id', $this->organisation_id)->orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage Board';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'board';
        return view('admin.board.manage')->with($data);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add Board';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'board';
        return view('admin.board.create')->with($data);
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

        $board = new Board();
        $board->name = $request->input('name');
        $board->description = $request->input('description');
        $board->status = 1;
        $board->sort_order = 1;
        $board->increment('sort_order');
        $board->save();
        return redirect()->route('board.index')->with('message', 'Board Added Successfully');
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
        $data['board'] = Board::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate Board";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'board';
        return view('admin.board.create')->with($data);
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
        $board = Board::find($id);
        $board->name = $request->input('name');
        $board->description = $request->input('description');
        $board->save();
        return redirect()->route('board.index')->with('message', 'Board Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $board = Board::find($id);
        $board->delete($id);
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
                $board = Board::find($id);
                $board->delete();
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
                $board = Board::find($id);
                $board->sort_order = $values->position;
                $result = $board->save();
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
        $board = Board::find($id);
        $board->status = $status;
        $result = $board->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}



