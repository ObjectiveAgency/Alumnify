<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use wrapperMethod;

class SubscriberController extends Controller
{
    public function index(){

    	$subs = \App\subscribers::all();
        return view('subscribers.index',['subs'=>$subs]);

    }

    public function store(Request $request){
	    $this->validate($request, [
	        'fname' => 'required|max:255',
	    ]);
	
	    // Create The Task...
	}

	


}
