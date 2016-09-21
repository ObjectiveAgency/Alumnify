<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use Illuminate\Support\Facades\Auth;
use Session; // needed to run the session flash message
use Illuminate\Support\Facades\Hash;//has function

class SettingsController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index(){
		return view('settings');
	}


	public function changeEmail(Request $request){
		//custom error messages
		$messages = [
    		'email' => 'Please enter a correct email format.',
		];

		// validation process
		$this->validate($request, [
        	'email' => 'required|email|max:255|unique:users',
    	],$messages);

		$user = Auth::user();
		$user->email=$request->email;
		$user->save();

		// confirmation message
		Session::flash('flash_message_email', 'Your email was updated.');

		return redirect()->back();
	}
    

    public function changePass(Request $request){
		$user = Auth::user();
		$oldPassword = $user->password;

		// check if current password is correct
		if (Hash::check($request->current_password, $oldPassword)) {
    		
    		//check if password match
    		if ($request->new_password == $request->confirm_new_password) {
    			$user->fill([
            		'password' => Hash::make($request->new_password)
        		])->save();

    			Session::flash('flash_message_password_success', 'Your password is changed.');
    			return redirect()->back();

    		}else{
    			Session::flash('flash_message_password', 'Your password did not match.');
    			return redirect()->back();
    		}
		}else{
			Session::flash('flash_message_password', 'Your current password is incorrect.');
			return redirect()->back();
		}



	}
}
