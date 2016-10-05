<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
    	if (Auth::check()) {
        	return redirect('/dashboard');
    	}else{
    		return view('welcome');
    	}
        
    }
}
