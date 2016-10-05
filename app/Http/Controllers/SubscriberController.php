<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;


class SubscriberController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function lists(Apiwrap $test){

        // $test->addList($test->getData('lists'));

        $lists = \App\lists::where('user_id', Auth::user()->id)->get();

        // dd(Auth::user()->id);

        return view('subscribers.lists', [
            'lists' => $lists,
        ]);

	}

    public function listSubscribers($listId, Apiwrap $test){

        $list = \App\lists::where('id', $listId)->get();//get details for the list

        $subscribers = \App\subscribers::where('list_id', $listId)->get();//get subscribers on the list
        // $test->addSubs();
        return view('subscribers.listSubscribers');

    }
}