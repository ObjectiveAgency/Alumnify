<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use Session;


// require __DIR__ . '/vendor/autoload.php';

use Knp\Snappy\Pdf;

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
    public function index()
    {   $api = new Apiwrap;
        if (!empty(Auth::user()->OAuth)) {
            $api->addCamp($api->getData('campaigns'));
            $api->addRep($api->getData('reports'));

            $campaigns = \App\campaigns::select(\DB::raw('campaigns.id, campaigns.name, lists.user_id'))
                        ->join('lists', 'campaigns.list_id', '=', 'lists.id')
                        ->where('lists.user_id','=',Auth::user()->id)->get();
            // dd($campaigns);
                        
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

                    // dd($sub->toArray());
                    // dd($api->getData("lists/$value->id/members/$id/activity"));
                    foreach($api->getData("lists/$value->id/members/$id/activity")['activity'] as $act){
                        
                       
                        \App\activity::updateorCreate([
                            'camp_id' => $act['campaign_id'],
                            'email_id' => $val->email,
                            'list_id' => $value->id
                            ],
                            [
                            'camp_id' => $act['campaign_id'],
                            $act['action'] => $act['timestamp'],
                            'email_id' => $val->email,
                            'list_id' => $value->id
                            ]);
                    }

// 
                } 
              
            } //dd($tmp);  
            
            return view('campaign.selectCampaign', [ 'campaigns' => $campaigns]);

        }else{
           return redirect('connections');
        }
    }

    public function details($campaignId){

        if (!empty(Auth::user()->OAuth)) {
            /**
            # get data from report DB table by the given campId
            **/
            
            $ev = \App\Reports::find($campaignId);
            if(empty($ev)){
                Session::flash('flash_message','No campaings reports found, Please check Mailchimp account for the associated reports');
                Session::flash('alertType',0);
                return redirect('campaign');
            }
            $campaigns = $this->index()->campaigns;
            $campaignSelected = \App\campaigns::find($campaignId);
            $charts = collect([]); //initiate charts data holder as collections     
            /**
            # Getting the data from activity DB table by the given campId, and taking email and list Id's only,
            # will used the Id's to reference the data from subscribers DB table.
            **/
            $ini_refs = \App\activity::select('email_id','list_id','open')->whereCamp_id($campaignId)->where('open','!=',null)->orderBy('open','asc')->get();
            
            $charts->least = \App\activity::select('email_id','list_id','open')->whereCamp_id($campaignId)->where('open','=',null)->orderBy('open','asc')->get()->map(function($value,$key)use(&$charts){
                $value = $value->email_id;
                return $value;
                 });

            $charts->email_sent = \App\campaigns::select('email_sent')->whereid($campaignId)->get()->map(function($value){return $value->email_sent;});          

            $charts->days = $ini_refs->map(function($value,$key){
               $value = $value->toArray();
               unset($value['email_id']);
                unset($value['list_id']);
                $value['open'] = date_create($value['open'])->format('Y-m-d');
                return  $value;})->sortBy('open')->groupBy('open');

            foreach($charts->days as $key => $value){
                $charts->days[$key] = round(((count($value)/$charts->email_sent[0])*100),2);

            }
            
            
                                              
            $subs_ref = ['listId'=>[],'email'=>[]]; //create a subscribers reference variable

            $ini_refs->each(function($value) use(&$subs_ref){
               
                array_push($subs_ref['listId'],$value['list_id']);
                array_push($subs_ref['email'],$value['email_id']);
 
            });

            $subs_ref['listId'] = array_unique($subs_ref['listId']);
           
            $subs_data = \App\subscribers::select('gender','age','country','state','city',
                \DB::raw('CONCAT(fname," ",mname," ", lname) as name'))
                    ->wherein('list_id',$subs_ref['listId'])
                    ->wherein('email',$subs_ref['email'])->get();


               
           
            $charts->put('gender',$subs_data //get and pipe data to extract gender
                        ->pipe(function($values){

                        $var['male'] = 0;
                        $var['female'] = 0;
                        if($values->count()!=0){
                        $var['total'] = $values->count();
                        }else{
                            $var['total']=1;
                        }
                        // dd($values->gender);
                        foreach($values as $item){
                            
                            if (strtolower($item->gender) === 'male')
                                $var['male'] += 1;
                            if (strtolower($item->gender) === 'female')
                                $var['female'] += 1;
                        }
                        
                        return $var;

                    }));
            
            if((sizeof($subs_ref['email'])-5)>0){
                 collect($subs_ref['email'])->take(5-sizeof($subs_ref['email']))->each(function($values) use(&$charts){
                    $charts->least->push($values);
                 });
                }                
            $charts->least = \App\subscribers::select(\DB::raw('CONCAT( subscribers.fname,  " ", subscribers.mname,  " ", subscribers.lname ) AS name, activity.open'))
                    ->join('activity','activity.email_id','=','subscribers.email')
                    ->where('activity.camp_id','=',$campaignId)
                    ->wherein('subscribers.email',$charts->least->toArray())
                    ->orderBy('activity.open','asc')->take(5)
                    ->get();

            $charts->name =\App\subscribers::select(\DB::raw('CONCAT( subscribers.fname,  " ", subscribers.mname,  " ", subscribers.lname ) AS name, activity.open'))
                    ->join('activity','activity.email_id','=','subscribers.email')
                    ->where('activity.camp_id','=',$campaignId)
                    ->wherein('subscribers.email',$subs_ref['email'])
                    ->orderBy('activity.open','asc')->take(5)
                    ->get(); 

            $charts->city = \App\subscribers::select(\DB::raw('city, COUNT(*) as count'))
                    ->whereList_id($subs_ref['listId'])
                    ->wherein('subscribers.email',$subs_ref['email'])
                    ->groupBy('city')
                    ->orderBy('count', 'desc')
                    ->orderByRaw("FIELD(email,'".implode("','",$subs_ref['email'])."')")->take(5)
                    ->get();
            
            $charts->state = \App\subscribers::select(\DB::raw('state,COUNT(*) as count'))
                    ->whereList_id($subs_ref['listId'])
                    ->wherein('subscribers.email',$subs_ref['email'])
                    ->groupBy('state')
                    ->orderBy('count', 'desc')
                    ->orderByRaw("FIELD(email,'".implode("','",$subs_ref['email'])."')")->take(5)
                    ->get();
            // dd($charts->state->toArray());
            $charts->country = \App\subscribers::select(\DB::raw('country,COUNT(*) as count'))
                    ->whereList_id($subs_ref['listId'])
                    ->wherein('subscribers.email',$subs_ref['email'])
                    ->groupBy('country')
                    ->orderBy('count', 'desc')
                    ->orderByRaw("FIELD(email,'".implode("','",$subs_ref['email'])."')")->take(5)
                    ->get();

            $charts->age = \App\subscribers::select(\DB::raw('age,COUNT(*) as count'))
                    ->whereList_id($subs_ref['listId'])
                    ->wherein('subscribers.email',$subs_ref['email'])
                    ->groupBy('age')
                    ->orderBy('count', 'desc')
                    ->orderByRaw("FIELD(email,'".implode("','",$subs_ref['email'])."')")->take(5)
                    ->get();

            
            // 
        
            // dd($charts);
        
            
            return view('campaign.details',['ev' => $ev, 'top5'=>$charts, 'campaigns'=> $campaigns, 'campaignSelected' => $campaignSelected]);

        }else{
           return redirect('connections');
        }
    
    }

    public function generatePDF($campaignId){

        // dd();

        // Display the resulting pdf in the browser
        // by setting the Content-type header to pdf
        $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
        header('Content-Type: application/pdf',true,200);
        header('Content-Disposition: attachment; filename="file.pdf"');
        echo $snappy->getOutput('http://www.github.com');

    }

}
