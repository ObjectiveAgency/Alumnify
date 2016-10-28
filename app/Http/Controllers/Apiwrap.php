<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \DrewM\MailChimp\MailChimp;

use \DrewM\MailChimp\Batch;

use Illuminate\Support\Facades\Auth;

class Apiwrap extends Controller
{ 	public $Oauthkey;

	private function setkey($param=''){
    if(empty($param)){
		$this->Oauthkey = \Auth::User()->OAuth;
    }else{
      $this->Oauthkey = $param;
    }
	}

	use ApiWrapperMethod;
  
}
trait ApiWrapperMethod {
    private function merge_fields($id){
        $tmp  = ["MNAME" => '{
                      "tag": "MNAME",
                      "name": "Middle Initial",
                      "type": "text",
                      "required": false,
                      "default_value": "",
                      "public": true,
                      "display_order": 3,
                      "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }',"AGE" =>
                    '{

                      "tag": "AGE",
                      "name": "Age",
                      "type": "number",
                      "required": true,
                      "default_value": "",
                      "public": true,
                      "display_order": 5,
                       "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }',"GENDER" =>
                    '{

                      "tag": "GENDER",
                      "name": "Gender",
                      "type": "text",
                      "required": true,
                      "default_value": "",
                      "public": true,
                      "display_order": 6,
                      "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }',"ADDRESS" =>
                    '{

                      "tag": "ADDRESS",
                      "name": "Address",
                      "type": "text",
                      "required": true,
                      "default_value": "",
                      "public": true,
                      "display_order": 7,
                      "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }',"CITY" =>
                    '{

                      "tag": "CITY",
                      "name": "City",
                      "type": "text",
                      "required": true,
                      "default_value": "",
                      "public": true,
                      "display_order": 8,
                      "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }',"STATE" =>
                    '{

                      "tag": "STATE",
                      "name": "State",
                      "type": "text",
                      "required": true,
                      "default_value": "",
                      "public": true,
                      "display_order": 9,
                      "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }',"COUNTRY" =>
                    '{

                      "tag": "COUNTRY",
                      "name": "Country",
                      "type": "text",
                      "required": true,
                      "default_value": "",
                      "public": true,
                      "display_order": 10,
                      "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }',"ZIP" =>
                    '{"tag": "ZIP",
                      "name": "Zip",
                      "type": "text",
                      "required": true,
                      "default_value": "",
                      "public": true,
                      "display_order": 11,
                      "options": {
                        "size": 25
                      },
                      "help_text": ""
                    }' ];
        $this->setkey();
        $MailChimp = new MailChimp($this->Oauthkey);
        $Batch = $MailChimp->new_batch();
        foreach($tmp as $value){

        $Batch->post('',"lists/$id/merge-fields",json_decode($value,true));
           
        }
        $Batch->execute();
        $id = $Batch->check_status()['id'];
        $MailChimp->new_batch($id);

        while(empty($Batch->check_status()['finished_operations'])){
            // $Batch->check_status()['errored_operations'];
        }
        // dd($Batch->check_status());
        if(!empty($Batch->check_status()['errored_operations'])){
            $result = 0; 
        }else{
            $result = 1;
        }
        // dd($result);
        $MailChimp->delete("/batches/$id");
        return $result;

    }

    private function addhook($data){
       
        $data['lists'][0]['id'];
     
        $tmp = '{"url" : "https://b229df99.ngrok.io/hook",
        "events" : {"subscribe" : true, 
        "unsubscribe" : true, 
        "profile" : true, 
        "cleaned" : true, 
        "upemail" : true, 
        "campaign" : true}, 
        "sources" : {"user" : true,
                    "admin" : true, 
                    "api" : true}}';
        // dd(json_decode($tmp,true));
        $this->merge_fields($data['lists'][0]['id']);
        $this->updateMembers('post','/lists/'.$data['lists'][0]['id'].'/webhooks',json_decode($tmp,true));
        
    }

    public function batch($list_id = string,$data = array()){
        
        $tmp = [];
        $this->setkey();
        $MailChimp = new MailChimp($this->Oauthkey);

        // $del = $MailChimp->get('batches');

        // foreach($del['batches'] as $value){
        //     $MailChimp->delete("/batches/".$value['id']);
            
        // }
        // dd($MailChimp->get('batches'));

        $Batch = $MailChimp->new_batch();
        
        foreach ($data as $value) {
               $tmp['merge_fields'] = $value;
               unset($tmp['merge_fields']['email_address']);
               $tmp['email_address'] = $value['email_address'];
               $tmp['status'] = 'subscribed';
               asort($tmp);
               $Batch->post('',"lists/$list_id/members",$tmp);
        }
       
        $Batch->execute();

        $id = $Batch->check_status()['id'];
        $MailChimp->new_batch($id);

        while(empty($Batch->check_status()['finished_operations'])){
            // $Batch->check_status()['errored_operations'];
        }
        
        if(!empty($Batch->check_status()['errored_operations'])){
            $result = 0; 
        }else{
            $result = 1;
        }
        // dd($result);
        $MailChimp->delete("/batches/$id");
        return $result;

    }
	
	public function updateMembers($method = string,$resource = string, $data =array() ){
       
		$this->setkey();
		$update = new MailChimp($this->Oauthkey);
        $chk = true;
        if($method==="del" || !strpos($resource, 'members')){
            $chk = false;
        }
      
        if($chk){
        $data = (object) $data;
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

             ];}
             
                   
        switch ($method){
        	case 'del':
        		$update->delete($resource);
                $chk = true;
        		break;
        	case 'update':
        		$update->patch($resource,$data);
        		break;
        	case 'post':
        		$update->post($resource,$data);
            // dd($resource);
        		break;
        	default:
        		die("Invalid method receive!");
        		break;
        }
        list($msg) = explode("Use",$update->getLastError());
          if(strpos($resource, 'webhooks') || strpos($resource, 'merge-fields')){
            $chk = true;
        }
        if(!$chk){
            unset($data);

            $data['lists'][0] = json_decode($update->getLastResponse()['body'],true);

            $this->addList($data);
        }
        
        return $msg;
        
           
            
			
	}

	public function addDatabase(){
            $this->addCamp($this->getData('campaigns'));
            $this->addRep($this->getData('reports'));
			// if(empty(count(\App\lists::all()))){

		 //        $this->addList($this->getData('lists'));
			// }
		    // if(empty(count(\App\subscribers::all()))){
                
		    // }
      //       if(empty(count(\App\campaigns::all()))){
                
      //       }
      //       if(empty(count(\App\Reports::all()))){
                
      //       }
            
	}
	 public function addRep($rep = array()){
    	foreach ($rep['reports'] as $key => $value){
     		$rep = new \App\Reports;
    		$rep::updateOrCreate(['id'=>$value['id']],[
    			'id'=>               $value['id'],
    			'campaign'=>         $value['campaign_title'],
    			'list_id'=>          $value['list_id'],
    			'emails_sent'=>      $value['emails_sent'],
    			'abuse_reports'=>    $value['abuse_reports'],
    			'unsubscribe'=>      $value['unsubscribed'],
    			'hard_bounce'=>      $value['bounces']['hard_bounces'],
    			'soft_bounce'=>      $value['bounces']['soft_bounces'],
    			'opens_total'=>      $value['opens']['opens_total'],
    			'unique_opens'=>     $value['opens']['unique_opens'],
    			'open_rate'=>        $value['opens']['unique_opens'],
    			'clicks_total'=>     $value['clicks']['clicks_total'],
    			'unique_clicks'=>    $value['clicks']['unique_clicks'],
    			'unique_subscriber_clicks'=> $value['clicks']['unique_subscriber_clicks'],
    			'click_rate'=>       $value['clicks']['click_rate'],
    			'click_rate'=>       $value['clicks']['click_rate'],
    			'sub_rate'=>         $value['list_stats']['sub_rate'],
    			'unsub_rate'=>       $value['list_stats']['unsub_rate'],
    			'list_open_rate'=>   $value['list_stats']['open_rate'],
    			'list_click_rate'=>  $value['list_stats']['click_rate'],
    			]);
    			}		
    }

	public function addCamp($camp = array() ){
      // dd($camp);
    	foreach ($camp['campaigns'] as $value){
    		$camp = new \App\campaigns;
			$camp::updateOrCreate(['id'=>$value['id']],[
									'id' => $value['id'],
									'name'=>$value['settings']['title'],
									'status'=>$value['status'],
									'email_sent'=>$value['emails_sent'],
									'list_id'=>$value['recipients']['list_id'],
									]);	
    	}
    	
    }


    public function getData($resource,$param = ''){
        $this->setkey($param);
        $getList = new Mailchimp($this->Oauthkey);

        $exclude = explode("/",$resource);
        $exclude = ['exclude_fields'=>$exclude[count($exclude)-1].'._links,_links'];

        $result = $getList->get($resource,$exclude);

        return $result;

    }

    public function addList($list = array()){
    	
    	
    	foreach ($list['lists'] as $value) {
           
        	$lists = new \App\lists;
           
        	$userId=Auth::user()->id;
            
        	$result = $lists::firstOrCreate([
                'id' => $value['id'],
                'user_id' => $userId,
                'name' => $value['name']
            ]);
          
          if($result->wasRecentlyCreated){
            $this->addhook($list);
            $this->addSubs();
            
          }
    	}
    }

    public function addSubs($result = null){
    	
        $index = 'merge_fields';
        $email = 'email_address';
        $id = 'unique_email_id';

        if(empty(count($result))){
     		$list = \App\lists::all();
                       
     		global $result;
        
            $result = array();
        	foreach($list as $value ){
    	    	
    	    	$list_id = $value->id;
                $this->setkey();
    	    	$result = array_merge_recursive($this->getData("lists/$list_id/members"),$result);

            }
                $result =$result['members'];
        }else{
                $index = 'merges';
                $email = 'email';
                $id = 'id';
        }
		if(!empty($result)){
            
	     	foreach($result as $value){
               // dd($value);
                
	    		global $subs;
                $subs = [];
	    		//$subs = new \App\subscribers;

	    		
                foreach($value[$index] as $key => $val){
                    $key = strtolower($key);
                    $subs[$key] = $val;
                }
                
                $subs += [

	    		'id' => $value[$id],
	    		'email' => $value[$email],
                'list_id' => $value['list_id']
                ];
                if($email === 'email'){
                    $value['status'] = 'subscribed';
                }

	    		$subs += ['status' => $value['status']];

                if($email !== 'email'){

                $subs +=[                  		
	    		'avg_open_rate' => $value['stats']['avg_open_rate'],
	    		'avg_click_rate' => $value['stats']['avg_click_rate'],
	    		'rank' => $value['member_rating']
                ];
	    		} 


          \App\subscribers::firstOrCreate($subs);
               
	    	}
            
		}	
    }



    


}
