<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \DrewM\MailChimp\MailChimp;

class Apiwrap extends Controller
{ use ApiWrapperMethod;
  
}
trait ApiWrapperMethod {

	public function addDatabase(){
		        $this->addList($this->getData('lists'));
                $this->addSubs(\App\lists::all());
                $this->addCamp($this->getData('campaigns'));
                $this->addRep($this->getData('reports'));
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
        $Oauthkey = \Auth::User()->OAuth;
        $getList = new Mailchimp($Oauthkey);

        $exclude = explode("/",$resource);
        $exclude = ['exclude_fields'=>$exclude[count($exclude)-1].'._links,_links'];

        $result = $getList->get($resource,$exclude);

        return $result;

    }

    public function addList($list = array()){
    	
    	foreach ($list['lists'] as $value) {    	
    	$list = new \App\lists;
    	$list::firstOrCreate(array('id' => $value['id'],'name'=>$value['name']));
    	//if($list->id = $value['id'])continue;
    	// $list->id = $value['id'];
    	// $list->name = $value['name'];
    	//$list->save();
    	
    		}
    }

    public function addSubs(){

 		$list = \App\lists::all();
 		$i=0;
 		$result = array();

    	foreach($list as $value ){
	    	
	    	$id = $list[$i]->id;
	    	$result = array_merge_recursive($this->getData("lists/$id/members"),$result);
	     	$i++;
    	}
		if(!empty($result)){//check if result is empty

	     	foreach($result['members'] as $value){

	    		global $subs;
	    		$subs = new \App\subscribers;

	    		foreach($value['merge_fields'] as $key => $val){
	    			$key = strtolower($key);
	    			$subs->$key = $val;
	    		}

	    		$subs->id = $value['id'];
	    		$subs->email = $value['email_address'];
	    		$subs->status = $value['status'];   		
	    		$subs->avg_open_rate = $value['stats']['avg_open_rate'];
	    		$subs->avg_click_rate = $value['stats']['avg_click_rate'];
	    		$subs->rank = $value['member_rating'];
	    		$subs->list_id = $value['list_id'];
	    		
	    		
	    		$i++;
	    		$subs->save();
	    	}

		}
    }



    


}