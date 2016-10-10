<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Session;
use Excel;

class SubscriberController extends Controller
{   private $api;
    public function __construct(){
        $this->api = new Apiwrap;
    }
// public function __construct()
//     {
//         $this->middleware('auth');
//     }
	// public function __construct(test $test){
	//  	$this->test = $test;
	//  }
	public function index(){
    	//dd($test->getData('reports'));
		//dd($test->getData('lists/469ad228d9/members'));
    	$subs = \App\subscribers::all();
        return view('subscribers.index',['subs'=>$subs]);

	}

	public function lists(){
        
        // $api->addSubs($api->getData('lists'));
       
        $lists = \App\lists::where('user_id', \Auth::user()->id)->get();

        // dd(Auth::user()->id);

        return view('subscribers.lists', [
            'lists' => $lists,
        ]);

	}

    public function listSubscribers($listId){

    	
        // $list = \App\lists::where('id', $listId)->get();//get details for the list
        


        $list = \App\lists::where('id', $listId)->get()->first();//get details for the list
        // dd($list->name);

        $subscribers = \App\subscribers::where('list_id', $listId)->get();//get subscribers on the list
        // dd($subscribers);
            return view('subscribers.listSubscribers', [
                'subscribers' => $subscribers,
                'list_id' => $listId,
                'listName' => $list->name
            ]);
        

    }

    public function subscriberProfile($listId, $id){
        $this->api->addSubs();
        $subscriber = \App\subscribers::find($id);
        

        return view('subscribers.subscriberProfile', [
            'subscriber' => $subscriber
        ]);

    }

    public function subscriberInfoUpdate(Request $request, $id){
        //dd($id);
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
        $this->api->updateMembers('update',
            "lists/$subscriber->list_id/members/$subscriber->id",
            $subscriber);
        Session::flash('flash_message', 'Profile Updated!');

        return redirect()->back();
    }

    public function subscriberAdd(Request $request, $listId){
               
        $resource='lists/'.$listId.'/members';
        $request['mname']=""; //set middle name to nothing

        $this->api->updateMembers('post',$resource, $request->all());
        
        Session::flash('flash_message', 'New subscriber added!');

        return redirect()->back();
    }

    public function subscriberAddBulk(Request $request, $listId){
        $msg = '';
        if ($request->hasFile('csvfile')) {
            $extension = $request->csvfile->getClientOriginalExtension();
            // dd($extension);

            $path = $request->file('csvfile')->getRealPath();
            $data = Excel::load($path, function($reader) {

            })->get()->toArray();
             

            if(!empty(count($data))){
                $finalData = [
                            "FNAME",
                            "MNAME",
                            "LNAME",
                            "email_address",
                            "AGE",
                            "GENDER",
                            "ADDRESS",
                            "CITY",
                            "STATE",
                            "COUNTRY",
                            "ZIP"
                 ];
                $tmp1 = []; 
                foreach ($data as $key => $value) { 

                        $i=0;
                        
                    //$finalData = array_fill_keys($finalData,array_values($value));
                    // dd($finalData[0]);
                    foreach($value as $val){

                        $tmp[$finalData[$i]] = $val;


                     $i++;
                         // foreach($finalData as $key => $carry){
                         //    $finalData[$key] = $val;
                         //    echo $key;

                         // }
                    };
                    
                    array_push($tmp1,$tmp);
                    
                    // $finalData[] = [
                    //     'fname' => $value->fname, 
                    //     'mname' => $value->mname,
                    //     'lname' => $value->lname,
                    //     'email' => $value->email,
                    //     'age' => intval($value->age),
                    //     'gender' => $value->gender,
                    //     'address' => $value->address,
                    //     'city' => $value->city,
                    //     'state' => $value->state,
                    //     'country' => $value->country,
                    //     'zip' => intval($value->zip)
                    // ];
                }
                // dd($listId);
                $this->api->batch($listId,$tmp1);
                $msg = "Success! CSV data are now Uploaded,\n 
                        Please reload page to see changes.";
            }else{
                $msg = "File contains no data or Invalid CSV header/data format!";
            }


            
        }else{
            $msg =  "no file received!";
        }
        Session::flash('flash_message', $msg);
        return redirect()->back();
        
    }

     public function subscriberDelete($id){
            dd($id);
     }

}