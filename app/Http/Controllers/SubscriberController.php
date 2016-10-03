<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;



class SubscriberController extends Controller
{
	// public function __construct(test $test){
	//  	$this->test = $test;
	//  }
	public function index(Apiwrap $test){
    	dd($test->getData('campaigns'));
    	$subs = \App\subscribers::all();
        return view('subscribers.index',['subs'=>$subs]);

		}
}

// class SubscriberController extends Controller
// {

//     public function index(ApiWrapper $wrapper){

//     	// $dd = $wrapper->getData('lists');
//     	// $subs = \App\subscribers::all();
//         // return view('subscribers.index',['subs'=>$subs]);
//         dd($wrapper->getData('lists'));


//     }

//     public function store(Request $request){
	    
	
// 	    // Create The Task...
// 	}

// }
