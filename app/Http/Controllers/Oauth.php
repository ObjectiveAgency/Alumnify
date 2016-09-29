<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Oauth extends Controller
{
    public function oauthShake(){

        if(!empty($_REQUEST['code'])){
                
                $code = $_REQUEST['code'];

                list($protocol,) = explode("/",$_SERVER['SERVER_PROTOCOL']);
                $uri = strtolower($protocol)."://".$_SERVER['HTTP_HOST'].$_SERVER['PATH_INFO'];

                

                $url = "https://login.mailchimp.com/oauth2/token";
                $data = "grant_type=authorization_code&client_id=277274991059&client_secret=c4e402cc790c57ec9fb69081a5bb042e&redirect_uri={$uri}&code={$code}";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                $response = json_decode(curl_exec($ch));
                
                curl_close($ch);
                $token = $response->access_token;
    

                //add Token to database; should be converted to function
                
            	$user = \Auth::user();
                $user->Oauth = $token;
            	$user->save();

            $var = "Connected";
          }else
            {
            $var = "Connection was unsuccessful";
                 }

    	return view('MP/test',['var'=>$var]);
    }
}
