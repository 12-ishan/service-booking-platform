<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\GeneralSettings;
use Illuminate\Support\Facades\Auth;


class GeneralSettingsController extends Controller
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

    public function contact()
    {
        $generalSettings = GeneralSettings::where('type', 'contact')->first();
       
        $data = [
            'generalSettings' => $generalSettings,
            
        ];
        $data["pageTitle"] = 'Contact Settings';
        $data["activeMenu"] = 'generalSettings';
        return view('admin.generalSettings.contact')->with($data);
    }
      

public function updateContact(Request $request)
{
   
    $contact = GeneralSettings::where('type', 'contact')->first();
    $contact->email = $request->input('email');
    $contact->phone = $request->input('phone');
    $contact->location = $request->input('location');
    $contact->save();
    $request->session()->flash('message', 'Contact Updated Successfully');
    return redirect()->route('contact');
}


}