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
            
        
        $data = (object) $this->api->getData('/');
       
        return view('subscribers.lists', [
            'lists' => $lists,'data'=>$data
        ]);

	}

    public function addList(Request $request){
        // dd($request->all());
        // $this->api->updateMembers("","");
        $data = json_decode('{
                "name":"'.$request->name.'",
                "contact": {
                    "company":"'.$request->company.'",
                    "address1": "'.$request->address1.'",
                    "address2": "'.$request->address2.'",
                    "city": "'.$request->city.'",
                    "state": "'.$request->state.'",
                    "zip": "'.$request->zip.'",
                    "country": "'.$request->country.'",
                    "phone": "'.$request->phone.'"
                },
                "permission_reminder": "'.$request->permission_reminder.'",
                "use_archive_bar": false,
                "campaign_defaults": {
                    "from_name": "'.$request->name.'",
                    "from_email": "'.$request->from_email.'",
                    "subject": "",
                    "language": "en"
                },
                "email_type_option":false,
                "notify_on_subscribe": "'.$request->notify_on_subscribe.'",
                "notify_on_unsubscribe": "'.$request->notify_on_unsubscribe.'"
            }',true);
        
        $msg = $this->api->updateMembers('post','/lists?fields=id,name',$data);

        if($msg === ""){
            $msg = 'New lists added!';
            $alertType = 1;
        }else{
            $msg = 'The subscriber your trying to add already exist!';
            $alertType = 0;
        };
        Session::flash('flash_message',$msg);
        Session::flash('alertType',$alertType);
        return redirect('subscribers');

    }

    public function deleteList(Request $request){

        $msg = $this->api->updateMembers('del','/lists/'.$request->list_id);

        if($msg === ""){
            $msg = 'New lists added!';
            $alertType = 1;
        }else{
            $msg = 'The subscriber your trying to add already exist!';
            $alertType = 0;
        };
        \App\lists::destroy($request->list_id);
        Session::flash('flash_message',$msg);
        Session::flash('alertType',$alertType);
        return redirect('subscribers');

    }

    public function listSubscribers($listId){


    	// dd($this->api->updateMembers());
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
            "lists/$subscriber->list_id/members/".md5($subscriber->id),
            $subscriber);
        Session::flash('flash_message', 'Profile Updated!');

        return redirect()->back();
    }

    public function subscriberAdd(Request $request, $listId){
               
        $resource='lists/'.$listId.'/members';
        $request['mname']=""; //set middle name to nothing
        
        $msg = $this->api->updateMembers('post',$resource, $request->all());
        if($msg === ""){
            $msg = 'New subscriber added!';
            $alertType = 1;
        }else{
            $msg = 'The subscriber your trying to add already exist!';
            $alertType = 0;
        };
        Session::flash('flash_message',$msg);
        Session::flash('alertType',$alertType);
        return redirect()->back();
    }

    public function subscriberAddBulk(Request $request, $listId){
        $msg = '';
        if ($request->hasFile('csvfile')) {
            $extension = $request->csvfile->getClientOriginalExtension();

            // dd($extension);
            if ($extension == 'csv') {
                $invalid=0;
                $path = $request->file('csvfile')->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get()->toArray();
                 
                 // dd($data);
    
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
                        // dd($value);
                        if( sizeof($value) == 11 ){

                            foreach($value as $val){
                                //check age and zip column if number
                                if ($i==4 || $i == 10) {
                                    if (is_numeric($val)) {
                                        // echo $val.' is a number ';
                                        $tmp[$finalData[$i]] = intval($val);
                                        // echo $val.' ';
                                    }else{
                                        // remove row on the save queue
                                        $tmp = [];
                                        break;
                                    }
                                }
                                // validate email columns
                                elseif ($i==3) {
                                    if (!filter_var($val, FILTER_VALIDATE_EMAIL) === false) {
                                        $tmp[$finalData[$i]] = $val;
                                    } else {
                                        // remove row on the save queue
                                        $tmp = [];
                                        // dd($val);
                                        break;
                                    }
                                }
                                else{
                                    $tmp[$finalData[$i]] = $val;
                                    // echo $val.' ';
                                }
                                
                                $i++;
                             
                            }

                            // removes row with invalid input
                            if (!empty($tmp)) {
                                array_push($tmp1,$tmp);
                            }
                            else{
                                $invalid++;
                                $invalidmsg='We have removed '.$invalid.' rows with invalid input!';
                            }
                        }else{
                            $msg= "Fields did not match on the requested format!";
                            break;
                        }
                        
                    }
                    echo $invalid.'<br>';
                    // dd($tmp1);
                    // dd($listId);
                    $this->api->batch($listId,$tmp1);
                    $msg = "Success! CSV data are now Uploaded,\n 
                            Please reload page to see changes.";
                }else{
                    $msg = "File contains no data or Invalid CSV header/data format!";
                }
                // dd($listId);
                $upload = $this->api->batch($listId,$tmp1);

                if($upload===0){
                    $msg = "Upload did not succeed, Please check data if already exist.";
                    $alertType = 0;
                }else{
                $msg = "Success! CSV data are now Uploaded,\n 
                        Please reload page to see changes.";
                $alertType = 1;}
            }else{
                $msg = "File contains no data or Invalid CSV header/data format!";
                $alertType = 0;

            }
        }else{
            $msg =  "no file received!";
            $alertType = 0;
        }
        Session::flash('flash_message', $msg);

        Session::flash('alertType', $alertType);

        return redirect()->back();
        
    }

     public function subscriberDelete($id){

            $item = \App\subscribers::find($id);
            $id = md5($item->email);
            $this->api->updateMembers("del","lists/$item->list_id/members/$id");
            \App\subscribers::destroy($item->id);
            Session::flash('flash_message', 'Success, subscriber has been deleted');

            return redirect("/subscribers/$item->list_id");
     }

}