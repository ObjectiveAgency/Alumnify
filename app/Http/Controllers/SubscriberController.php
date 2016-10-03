<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class SubscriberController extends Controller
{	
	// public function __construct(test $test){
	// 	$this->test = $test;
	// }
    public function index(test $test){
    	dd($test->getData('campaigns'));
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
