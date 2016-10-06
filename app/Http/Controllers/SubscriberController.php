<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Session;

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
        // dd($subscriber);

        return view('subscribers.subscriberProfile', [
            'subscriber' => $subscriber
        ]);

    }

    public function subscriberInfoUpdate(Request $request, $id){

        $subscriber=\App\subscribers::find($id);

        $input = $request->all();

        if ($request->has('fname')) {
            echo $input['fname'];
        }else{
            $input['fname'] = $subscriber->fname;
        }

        if ($request->has('lname')) {
            echo $input['lname'];
        }else{
            $input['lname'] = $subscriber->lname;
        }

        if ($request->has('email')) {
            echo $input['email'];
        }else{
            $input['email'] = $subscriber->email;
        }

        if ($request->has('gender')) {
            echo $input['gender'];
        }else{
            $input['gender'] = $subscriber->gender;
        }

        if ($request->has('age')) {
            echo $input['age'];
        }else{
            $input['age'] = $subscriber->age;
        }
        
        if ($request->has('city')) {
            echo $input['city'];
        }else{
            $input['city'] = $subscriber->city;
        }

        if ($request->has('country')) {
            echo $input['country'];
        }else{
            $input['country'] = $subscriber->country;
        }

        if ($request->has('state')) {
            echo $input['state'];
        }else{
            $input['state'] = $subscriber->state;
        }

        if ($request->has('zip')) {
            echo $input['zip'];
        }else{
            $input['zip'] = $subscriber->zip;
        }

        $subscriber->fill($input)->save();

        Session::flash('flash_message', 'Profile Updated!');

        return redirect()->back();
    }
}