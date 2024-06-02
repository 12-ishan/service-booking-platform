<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Contact;
use Validator;


class ContactController extends Controller
{
    //
    public function insert(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
        }

        $contact = new Contact();

        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->message = $request->input('message');
       
        $contact->status = 1;
        $contact->sortOrder = 1;

        $contact->increment('sortOrder');

        $contact->save();

        $response = [
            'message' => 'contact inserted',
            'status' => '1'
        ];

        return response()->json($response, 201);
    
}
}


   
   

