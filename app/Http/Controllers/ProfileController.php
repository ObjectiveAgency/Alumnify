<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Session; // needed to run the session flash message
use Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function update(Request $request){

    	$user = Auth::user();
    	$input = $request->all();
    	$user->fill($input)->save();

    	// confirmations message
    	Session::flash('flash_message', 'Profile Updated');
    	
    	// redirect back to the profile page with confirmation
    	return redirect()->back();
    }

    public function updateImage(Request $request){
    	
    	if ($request->hasFile('image')) {
    		$image = $request->file('image');
    		$filename = time().'.'.$image->getClientOriginalExtension();

    		Image::make($image)->resize(300,300)->save(public_path('/assets/img/uploads/'.$filename));

    		$user=Auth::user();
    		$user->image=$filename;
    		$user->save();

    		Session::flash('flash_message', 'Profile Updated');
    	}
    	return redirect()->back();
    }
}
