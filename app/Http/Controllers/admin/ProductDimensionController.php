<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\ProductDimension;
use App\Model\Admin\Country;


class ProductDimensionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($productId)
    {
        $data = array();

        $data["productDimension"] = ProductDimension::orderBy('sortOrder')->get();
        $data["productId"] = $productId;

        $data["pageTitle"] = 'Manage Product Dimension';
        $data["activeMenu"] = 'configurator';
        return view('admin.productDimension.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($productId)
    {
        $data = array();

        $data["country"] = Country::orderBy('sortOrder')->get();

        $data["productId"] = $productId;
        $data["pageTitle"] = 'Add Product Dimension';
        $data["activeMenu"] = 'configurator';
        return view('admin.productDimension.create')->with($data);
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
            'squareMeters' => 'required',
            'price' => 'required',
        ]);

        $productDimension = new ProductDimension();

        $productId = $request->input('productId');

        $productDimension->squareMeters = $request->input('squareMeters');
        $productDimension->price = $request->input('price');
        $productDimension->productId = $productId;
       
        $productDimension->status = 1;
        $productDimension->sortOrder = 1;

        $productDimension->increment('sortOrder');

        $productDimension->save();

        return redirect()->route('productDimension.index',['productId' => $productId])->with('message', 'Product Dimension Added Successfully');
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
    public function edit($id, $productId)
    {

        $data = array();

        $data['productDimension'] = ProductDimension::find($id);

        $data["country"] = Country::orderBy('sortOrder')->get();

        $data["productId"] = $productId;

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Product Dimension';
        $data["activeMenu"] = 'configurator';
        return view('admin.productDimension.create')->with($data);
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
        
       // print_r("test");die();

        $this->validate(request(), [
            'squareMeters' => 'required',
            'price' => 'required',
        ]);
        
        $id = $request->input('id');
        $productId = $request->input('productId');

        $productDimension = ProductDimension::find($id);

        $productDimension->squareMeters = $request->input('squareMeters');
        $productDimension->price = $request->input('price');
       // $productDimension->productId = $request->input('productId');
        
        $productDimension->save();

        return redirect()->route('productDimension.index',['productId' => $productId])->with('message', 'Product Dimension Updated Successfully');
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
        $productDimension = ProductDimension::find($id);
        $productDimension->delete($id);

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
                $productDimension = ProductDimension::find($id);
                $productDimension->delete();
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
                $productDimension = ProductDimension::find($id);
                $productDimension->sortOrder = $values->position;
                $result = $productDimension->save();
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

        $productDimension = ProductDimension::find($id);
        $productDimension->status = $status;
        $result = $productDimension->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
