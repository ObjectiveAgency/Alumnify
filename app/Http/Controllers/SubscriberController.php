<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


<<<<<<< HEAD
class SubscriberController extends Controller
{	
	// public function __construct(test $test){
	// 	$this->test = $test;
	// }
    public function index(test $test){
    	dd($test->getData('campaigns'));
    	$subs = \App\subscribers::all();
        return view('subscribers.index',['subs'=>$subs]);
=======

class SubscriberController extends Controller
{

    public function index(ApiWrapper $wrapper){

    	// $dd = $wrapper->getData('lists');
    	// $subs = \App\subscribers::all();
        // return view('subscribers.index',['subs'=>$subs]);
        dd($wrapper->getData('lists'));
>>>>>>> 76b3894d4b0e70a284782185f926f89dc12a791e

    }

    public function store(Request $request){
	    
	
	    // Create The Task...
	}

}
