<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DashboardController extends Controller
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
    {
        function errmsg($err){
            Session::flash('flash_message',$err);
            Session::flash('alertType',0);
        }
        if (!empty(Auth::user()->OAuth)) {
            $listid = \App\lists::select('id')->whereUser_id(Auth::user()->id)->get()->toArray();

            if(empty($listid)){
                errmsg('Please create list first!');
                return redirect('subscribers');
            }
                
                $charts = collect();
                
                $activity_data = \App\activity::select(\DB::raw('TIME_TO_SEC(TIMEDIFF(open,sent)) AS time'),'email_id','camp_id','open')->wherein('list_id',$listid)->orderBy('open')->
                get();
                


                $charts['least5'] = collect();
                $charts['line'] = collect();
                $charts['line']->total = $activity_data->count();
                foreach($activity_data as $key => $value){
                        
                        if ($value->time === null){
                        $charts['least5']->push($activity_data[$key]);
                        unset($activity_data[$key]);}
                }
                 
                $charts['line'] = $activity_data->map(function($value){

                        $value->month = getdate(strtotime($value->open))['month'];

                        return $value;
                })->groupBy('month')->map(function($value)use($charts){
                    return round(($value->count()/$charts['line']->total)*100,2);
                });
                 // dd($charts['line']);
                
                 
                $charts['least5'] = $charts['least5']->groupBy('email_id')->map(function($value){
                    return $value->count('email_id');
                });

                // dd($charts['least5']);
                $activity_data = $activity_data->values()->groupBy('email_id');
                // dd($activity_data->values()->toArray());
                $charts['top5'] = collect();              
                $subref = $activity_data->map(function($value,$key) use(&$charts){

                    $value->put('count',$value->count());  
                    $value->put('time',$value->sum('time'));
                    $value->put('email',$key);
                    


                    // $value->put('campaign',$value->count('camp_id'));
                    for($i = 0;$i < $value['count'];$i++)
                        unset($value[$i]);
                    
                    $charts['top5']->put($key,$value->toArray());
                    // dd($charts['top5'][$key],$charts['top5'][$key]['count']);
                    if(isset($charts['least5'][$key])){
                        $value['count'] = $value['count'] - $charts['least5'][$key];
                        if($value['count'] < 1){
                            $charts['least5'][$key] = $value['count'] * -1;
                            unset($charts['top5'][$key]);
                        }else{
                              $charts['top5'][$key]['count'] = $value['count'];
                        }
                    }
                    return $value;

                });
                // dd();
                if(empty($subref->count())){
                    errmsg('No associated data found, Please make sure that the campaigns still exist at your Mailchimp account');
                    return redirect('campaign');
                }

                $charts['least5'] = $charts['least5']->sort()->reverse()->keys();
                function _orderSort($var){
                           $var = $var->sortByDesc('count')->groupBy('count')->map(function($value){
                                $value = $value->sortBy('time');
                                return $value;
                                })->flatten()->filter(function ($value, $key) {
                                    if(!is_numeric($value))
                                    return $value;
                                })->values()->toArray();

                                return $var;
                            }
                
                 $charts['top5'] = _orderSort($charts['top5']);

                 $subref = _orderSort($subref);
                
                // $charts['top5'] = $charts['top5']

                $charts['gender'] = \App\subscribers::select(\DB::raw('gender'))
                            ->wherein('email',$subref)
                            ->get();

                $charts->put('gender',$charts['gender'] //get and pipe data to extract gender
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
                $tmp = $charts['gender'];
                unset($tmp['total']);
                arsort($tmp);
                $tmp = array_keys($tmp);
                $charts->tmp = $tmp;

                $charts['countries'] = \App\subscribers::select(\DB::raw('country, COUNT( * ) AS count'))
                            ->wherein('email',$subref)
                            ->groupBy('country')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$subref)."')")->take(5)->get();

                $charts['state'] = \App\subscribers::select(\DB::raw('state, COUNT( * ) AS count'))
                            ->wherein('email',$subref)
                            ->groupBy('state')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$subref)."')")->take(5)->get();

                $charts['city'] = \App\subscribers::select(\DB::raw('city, COUNT( * ) AS count'))
                            ->wherein('email',$subref)
                            ->groupBy('city')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$subref)."')")->take(5)->get(); 

                $charts['age'] = \App\subscribers::select(\DB::raw('age, COUNT( * ) AS count'))
                            ->wherein('email',$subref)
                            ->groupBy('age')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$subref)."')")->take(5)->get();
                
                
                $charts['campaign'] = \App\campaigns::select('name','activity.camp_id',\DB::raw('count(*) as count'))
                            ->join('activity','activity.camp_id', '=', 'campaigns.id')
                            ->where('activity.open','<>','null')
                            ->where('campaigns.list_id','=',$listid)
                            ->groupBy('camp_id')
                            ->orderBy('count','desc')->get();
                            
                // dd(implode(collect($charts['top5'])->take(-1)->values()->toArray()));
                if((sizeof($charts['top5'])-5)>0){
                 collect($charts['top5'])->take(5-sizeof($charts['top5']))->each(function($values) use(&$charts){
                    $charts['least5']->push($values);
                 });
                }

                
                $charts['top5'] = \App\subscribers::select(\DB::raw('CONCAT(fname," ",mname," ",lname) as name'))
                            ->wherein('email',$charts['top5'])
                            ->orderByRaw("FIELD(email,'".implode("','",$charts['top5'])."')")->take(5)->get();

                $charts['least5'] = \App\subscribers::select('age','city','state',\DB::raw('CONCAT(fname," ",mname," ",lname) as name'))
                            ->wherein('email',$charts['least5'])
                            ->orderByRaw("FIELD(email,'".implode("','",$charts['least5']->toArray())."')")->take(5)->get();
                
                function jose($var,$param){
                return $param->groupBy($var)->map(function($value,$key)use(&$param){
                    $value->put('count',$value->count());
                    unset($value[0]);
                    return $value;
                })->sortByDesc('count')->take(1)->keys();}

                $charts['least'] = [jose('age',$charts['least5']),jose('city',$charts['least5']),jose('state',$charts['least5'])];
             // dd($charts->toArray());
            return view('dashboard',['charts' => $charts]);
        }else{
            return redirect('connections');
        }
    }
}
