<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apiwrap $api)
    {
        if (!empty(Auth::user()->OAuth)) {

            $campaigns = \App\campaigns::where('user_id', '=', Auth::user()->id)->get();
            /*
                PLACE CODES HERE
            */
                $list = \App\lists::where('user_id', '=', Auth::user()->id)->get();
               global $tmp;
               $tmp = [];
            foreach($list as $value){
                
                $sub = \App\subscribers::where('list_id', '=', $value->id)->get();

               
                foreach($sub as $val){
                    $id = md5(strtolower($val->email));
                    // echo "<pre>","$value->id : $val->email : $id","</pre>";
                    // print_r($api->getData("lists/$value->id/members/$id/"));
                    foreach($api->getData("lists/$value->id/members/$id/activity")['activity'] as $act){
                        
                       
                        \App\activity::updateorCreate([
                            'camp_id' => $act['campaign_id'],
                            'email_id' => $val->email,
                            'list_id' => $value->id
                            ],
                            [
                            'camp_id' => $act['campaign_id'],
                            $act['action'] => date("Y-m-d H:i:s",strtotime($act['timestamp'])),
                            'email_id' => $val->email,
                            'list_id' => $value->id
                            ]);
                        // dd($act);
                        // echo "<pre>";
                        // var_export($act);
                        // echo "</pre>";

                    }

// 
                } 
              
            } //dd($tmp);  

            // dd($campaigns);
            
            return view('campaign.selectCampaign', [ 'campaigns' => $campaigns]);

        }else{
           return redirect('connections');
        }
    }

    public function details($campaignId){

        if (!empty(Auth::user()->OAuth)) {
            /*
                PLACE CODES HERE
            */
            return view('campaign.details');

        }else{
           return redirect('connections');
        }
    
    }
}
