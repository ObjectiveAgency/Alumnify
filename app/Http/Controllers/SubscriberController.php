<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;


class SubscriberController extends Controller
{
// public function __construct()
//     {
//         $this->middleware('auth');
//     }
	// public function __construct(test $test){
	//  	$this->test = $test;
	//  }
	public function index(Apiwrap $test){
    	//dd($test->getData('reports'));
		//dd($test->getData('lists/469ad228d9/members'));
    	$subs = \App\subscribers::all();
        return view('subscribers.index',['subs'=>$subs]);

	}

	public function lists(Apiwrap $test){

        // $test->addList($test->getData('lists'));

        $lists = \App\lists::where('user_id', \Auth::user()->id)->get();

        // dd(Auth::user()->id);

        return view('subscribers.lists', [
            'lists' => $lists,
        ]);

	}

    public function listSubscribers($listId, Apiwrap $test){

    	
        // $list = \App\lists::where('id', $listId)->get();//get details for the list
        


        $list = \App\lists::where('id', $listId)->get()->first();//get details for the list
        // dd($list->name);

        $subscribers = \App\subscribers::where('list_id', $listId)->get();//get subscribers on the list
        // $test->addSubs();
        return view('subscribers.listSubscribers', [
            'subscribers' => $subscribers,
            'listName' => $list->name
        ]);

    }

    public function subscriberProfile($listId, $id){

        $subscriber = \App\subscribers::find($id);


        return view('subscribers.subscriberProfile');

    }
}