<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \DrewM\MailChimp\MailChimp;

class test extends Controller
{ use wrapperMethod;
    public function test(){
    	// $res = 'lst/1234';
    	// $res = explode("/",$res);
    	// echo $res[count($res)-1];
    	// $key = 'ID';
    	// $subs = new \App\subscribers;
    	// $key = strtolower($key);
    	// $subs->$key = "321";
    	// $subs->save();
    	// $subs = \App\subscribers::all();
    	
    	// dd($subs[0][$key]);

    	$this->addCamp($this->getData('campaigns'));
    	
    	//dd($subs);
    	
    	// $var = $this->getList();
    	// $this->addList($var);
    	
    }
}
trait wrapperMethod{

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