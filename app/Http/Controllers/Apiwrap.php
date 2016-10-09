<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \DrewM\MailChimp\MailChimp;

use Illuminate\Support\Facades\Auth;

class Apiwrap extends Controller
{ 	public $Oauthkey;

	public function setkey(){
		$this->Oauthkey = \Auth::User()->OAuth;
	}

	use ApiWrapperMethod;
  
}
trait ApiWrapperMethod {
	
	public function updateMembers($method = string,$resource = string, $data = array()){
		$data = (object) $data;
		// dd($this->getData($resource));
		$update = new MailChimp($this->Oauthkey);
		$data = [
			"email_address"=>$data->email,
            "status"=>$data->status,//subcribed, unsubscribed, cleaned, pending
            "merge_fields"=>[
                            "FNAME"=>$data->fname,//first name
                            "MNAME"=>$data->mname,
                            "LNAME"=>$data->lname,//last name
                            "AGE"=>$data->age,
                            "GENDER"=>$data->gender,
                            "ADDRESS"=>$data->address,
                            "CITY"=>$data->city,
                            "STATE"=>$data->state,
                            "COUNTRY"=>$data->country,
                            "ZIP"=>$data->zip
                 ]

             ];
        switch ($method){
        	case 'del':
        		$update->delete($resource);
        		break;
        	case 'update':
        		$update->patch($resource,$data);
        		break;
        	case 'post':
        		$update->post($resource,$data);
        		break;
        	default:
        		die("Invalid method receive!");
        		break;
        }

        //dd($update);
           
            
			
	}

	public function addDatabase(){
			if(empty(count(\App\lists::all()))){
		        $this->addList($this->getData('lists'));
			}
		    if(empty(count(\App\subscribers::all()))){
                $this->addSubs(\App\lists::all());
		    }
            if(empty(count(\App\campaigns::all()))){
                $this->addCamp($this->getData('campaigns'));
            }
            if(empty(count(\App\reports::all()))){
                $this->addRep($this->getData('reports'));
            }
            
	}
	 public function addRep($rep = array()){
    	foreach ($rep['reports'] as $key => $value){
     		$rep = new \App\Reports;
    		$rep::firstOrCreate([
    			'id'=> $value['id'],
    			'campaign'=> $value['campaign_title'],
    			'list_id'=> $value['list_id'],
    			'emails_sent'=> $value['emails_sent'],
    			'abuse_reports'=> $value['abuse_reports'],
    			'unsubscribe'=> $value['unsubscribed'],
    			'hard_bounce'=> $value['bounces']['hard_bounces'],
    			'soft_bounce'=> $value['bounces']['soft_bounces'],
    			'opens_total'=> $value['opens']['opens_total'],
    			'unique_opens'=> $value['opens']['unique_opens'],
    			'open_rate'=> $value['opens']['unique_opens'],
    			'clicks_total'=> $value['clicks']['clicks_total'],
    			'unique_clicks'=> $value['clicks']['unique_clicks'],
    			'unique_subscriber_clicks'=> $value['clicks']['unique_subscriber_clicks'],
    			'click_rate'=> $value['clicks']['click_rate'],
    			'click_rate'=> $value['clicks']['click_rate'],
    			'sub_rate'=> $value['list_stats']['sub_rate'],
    			'unsub_rate'=> $value['list_stats']['unsub_rate'],
    			'list_open_rate'=> $value['list_stats']['open_rate'],
    			'list_click_rate'=> $value['list_stats']['click_rate'],
    			]);
    			}		
    }

	public function addCamp($camp = array() ){

    	foreach ($camp['campaigns'] as $value){
    		$camp = new \App\campaigns;
			$camp::firstOrCreate(array(
									'id' => $value['id'],
									'name'=>$value['settings']['title'],
									'status'=>$value['status'],
									'email_sent'=>$value['emails_sent'],
									'list_id'=>$value['recipients']['list_id'],
									));	
    	}
    	
    }


    public function getData($resource){
        
        $getList = new Mailchimp($this->Oauthkey);

        $exclude = explode("/",$resource);
        $exclude = ['exclude_fields'=>$exclude[count($exclude)-1].'._links,_links'];

        $result = $getList->get($resource,$exclude);

        return $result;

    }

    public function addList($list = array()){
    	
    	
    	foreach ($list['lists'] as $value) {

    	$list = new \App\lists;
    	$userId=Auth::user()->id;
    	
    	$list::firstOrCreate(array('id' => $value['id'],'user_id'=>$userId,'name'=>$value['name']));

    	//if($list->id = $value['id'])continue;
    	// $list->id = $value['id'];
    	// $list->name = $value['name'];
    	//$list->save();
    	
    		}
    }

    public function addSubs($result = null){
        $key = 'merge_fields';
        $email = 'email_address';
        if(empty(count($result))){
     		$list = \App\lists::all();
                        
     		global $result;
        
            $result = array();
        	foreach($list as $value ){
    	    	
    	    	$id = $value->id;
                $this->setkey();
    	    	$result = array_merge_recursive($this->getData("lists/$id/members"),$result);
                }
            $result =$result['members'];
        }else{
                $key = 'merges';
                $email = 'email';
        }
		if(!empty($result)){//check if result is empty
             // dd($result);
	     	foreach($result as $value){
               // dd($value);
	    		global $subs;
	    		$subs = new \App\subscribers;

	    		
                foreach($value[$key] as $key => $val){
                    $key = strtolower($key);
                    $subs->$key = $val;
                }
	    		$subs->id = $value['id'];
	    		$subs->email = $value[$email];
                $subs->list_id = $value['list_id'];
                if($email === 'email'){
                    $value['status'] = 'subscribed';
                }
	    		$subs->status = $value['status'];
                if($email !== 'email'){                  		
	    		$subs->avg_open_rate = $value['stats']['avg_open_rate'];
	    		$subs->avg_click_rate = $value['stats']['avg_click_rate'];
	    		$subs->rank = $value['member_rating'];
	    		} 
	    		$subs->save();
	    	}

		}
		return $result;
    }



    


}