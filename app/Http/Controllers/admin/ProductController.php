<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Product;
use App\Model\Admin\Country;


class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dimension($productId)
    {
        //print_r($productId);die();

        $data = array();

        $data["product"] = Product::orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Manage Price By Dimension';
        $data["activeMenu"] = 'product';
        return view('admin.product.dimension')->with($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();

        $data["product"] = Product::orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Manage Product';
        $data["activeMenu"] = 'product';
        return view('admin.product.manage')->with($data);
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

        $data["pageTitle"] = 'Add Product';
        $data["activeMenu"] = 'product';
        return view('admin.product.create')->with($data);
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

        $product = new Product();

        $product->name = $request->input('name');
        $product->contactPerson = $request->input('contactPerson');
        $product->weekendNumber = $request->input('weekendNumber');
        $product->address1 = $request->input('address1');
        $product->address2 = $request->input('address2');
        $product->zip = $request->input('zip');
        $product->town = $request->input('town');
        $product->location = $request->input('location');
        $product->countryId = $request->input('countryId');
        $product->localPhone = $request->input('localPhone');
        $product->cellPhone = $request->input('cellPhone');
        $product->email = $request->input('email');
        $product->website = $request->input('website');
        $product->capacity = $request->input('capacity');
        $product->genereOfMusic = $request->input('genereOfMusic');
        $product->priority = $request->input('priority');
        $product->comment = $request->input('comment');
        $product->status = 1;
        $product->sortOrder = 1;

        $product->increment('sortOrder');

        $product->save();

        return redirect()->route('product.index')->with('message', 'Product Added Successfully');
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

        $data['product'] = Product::find($id);

        $data["country"] = Country::orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Product';
        $data["activeMenu"] = 'product';
        return view('admin.product.create')->with($data);
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


        $product = Product::find($id);

        $product->name = $request->input('name');
        $product->contactPerson = $request->input('contactPerson');
        $product->weekendNumber = $request->input('weekendNumber');
        $product->address1 = $request->input('address1');
        $product->address2 = $request->input('address2');
        $product->zip = $request->input('zip');
        $product->town = $request->input('town');
        $product->location = $request->input('location');
        $product->countryId = $request->input('countryId');
        $product->localPhone = $request->input('localPhone');
        $product->cellPhone = $request->input('cellPhone');
        $product->email = $request->input('email');
        $product->website = $request->input('website');
        $product->capacity = $request->input('capacity');
        $product->genereOfMusic = $request->input('genereOfMusic');
        $product->priority = $request->input('priority');
        $product->comment = $request->input('comment');
        
        $product->save();

        return redirect()->route('product.index')->with('message', 'Product Updated Successfully');
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
        $product = Product::find($id);
        $product->delete($id);

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
                $product = Product::find($id);
                $product->delete();
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
                $product = Product::find($id);
                $product->sortOrder = $values->position;
                $result = $product->save();
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

        $product = Product::find($id);
        $product->status = $status;
        $result = $product->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
