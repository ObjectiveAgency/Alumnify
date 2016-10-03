<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;



class SubscriberController extends Controller
{

    public function index(ApiWrapper $wrapper){

    	// $dd = $wrapper->getData('lists');
    	// $subs = \App\subscribers::all();
        // return view('subscribers.index',['subs'=>$subs]);
        dd($wrapper->getData('lists'));

    }

    public function store(Request $request){
	    
	
	    // Create The Task...
	}

}
