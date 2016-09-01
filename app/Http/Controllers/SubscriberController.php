<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SubscriberController extends Controller
{
    public function index()
    {
        return view('subscribers');
    }
}
