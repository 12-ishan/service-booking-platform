<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Organisation;

class OrganisationController extends Controller
{
    //
    public function store(Request $request)
    {
       // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required|string',
            'email' => 'required',
            'phone' => 'required'
        ]);

        // Create a new Post instance
        
        $organisation = new Organisation();
        $organisation->name = $validatedData['name'];
        $organisation->address = $validatedData['address'];
        $organisation->email = $validatedData['email'];
        $organisation->phone = $validatedData['phone'];
        $organisation->status = 1;
        $organisation->sortOrder = 1;
        
        // Save the post to the database
        $organisation->save();

        // Return a response indicating success
        return response()->json(['message' => 'Data inserted  successfully'], 201);
    
    
}
}
