<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \DrewM\MailChimp\MailChimp;

class SubscriberController extends Controller
{
    public function index()
    {
        return view('subscribers.index');
    }

    public function store(Request $request)
	{
	    $this->validate($request, [
	        'fname' => 'required|max:255',
	    ]);
	
	    // Create The Task...
	}

	public function getList(){
		$Oauth = \Auth::User()->OAuth;
		$getList = new Mailchimp($Oauth);

		$resource = 'lists';
		$exclude = ['exclude_fields'=>'lists._links,_links'];

		$result = $getList->get($resource,$exclude);

		dd($result);

	}

}
