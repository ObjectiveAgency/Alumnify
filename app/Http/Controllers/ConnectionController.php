<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Session; // needed to run the session flash message

class ConnectionController extends Controller
{
    public function index(Apiwrap $api)
    {   
    if(!empty(Auth::User()->OAuth)){
         $api->addDatabase();}
    return view('connections');
     }

    public function oauthShake(Apiwrap $api){

        if(!empty($_REQUEST['code'])){
                
                $code = $_REQUEST['code'];

                list($protocol,) = explode("/",$_SERVER['SERVER_PROTOCOL']);
                $uri = strtolower($protocol)."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

                

                $url = "https://login.mailchimp.com/oauth2/token";
                $uri = str_replace("?", "&",$uri);
                $data = "grant_type=authorization_code&client_id=277274991059&client_secret=c4e402cc790c57ec9fb69081a5bb042e&redirect_uri={$uri}";
                // echo $data;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                $response = json_decode(curl_exec($ch));
                
                curl_close($ch);

                $token = $response->access_token;
                
                $mp=$api->getData('/',$token);
                //add Token to database; should be converted to function
                $result = \App\mp_accounts::firstOrCreate([
                    'id'=>$mp['account_id'],
                    'email'=>$mp['email'],
                    'username'=>$mp['username']
                    ]);
                if($result->wasRecentlyCreated){
            	$user = \Auth::user();
             
                $user->Oauth = $token;
            	$user->save();

            	$var = 'Your mailchimp account is now connected!';
                $alert = 1;
                }else{
            $var = "Oops, account is already in use by other user";
            $alert = 0;
            }
          }else
            {
            $var = "Connection was unsuccessful";
            $alert = 0;
                 }
        Session::flash('flash_message',$var);
        
        Session::flash('alertType',$alert);
    	return redirect('connections');
    }

}
