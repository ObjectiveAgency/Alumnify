<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \DrewM\MailChimp\Webhook;

class webhookController extends Controller
{
    public function get(){

    	if($_SERVER['HTTP_USER_AGENT']==="MailChimp.com WebHook Validator")
    	return "Welcome to Alumnify WebHook";
    	else
    	return view('/');
    }

    public function post(Apiwrap $api){

    	Webhook::subscribe('subscribe', function($data){
    		$dd($data);
    		$api = new Apiwrap();
    		$datas=['data'=>$data];
    		$api->addSubs($datas);
    	});

    	Webhook::subscribe('unsubscribe', function($data){

    		\App\subscribers::destroy($data['id']);
    		
    	});

    	Webhook::subscribe('campaign', function($data){

    	});

    }
}
