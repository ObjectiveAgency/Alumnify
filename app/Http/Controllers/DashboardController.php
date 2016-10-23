<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!empty(Auth::user()->OAuth)) {
            $listid = \App\lists::select('id')->whereUser_id(Auth::user()->id)->get()->toArray();
           
                $charts = collect();
                
                $activity_data = \App\activity::select(\DB::raw('TIME_TO_SEC(TIMEDIFF(open,sent)) AS time'),'email_id','camp_id')->wherein('list_id',$listid)->orderBy('open')->
                get();
               
                
                
                foreach($activity_data as $key => $value){
                        
                        if ($value->time === null)
                        unset($activity_data[$key]);
                }
                
                
                $activity_data = $activity_data->values()->groupBy('email_id');
                // dd($activity_data->values()->toArray());
                $tmp = [];
                $charts['top5'] = $activity_data->map(function($value,$key)use(&$tmp){

                    $value->put('count',$value->count());  
                    $value->put('time',$value->sum('time'));
                    $value->put('email',$key);

                    // $value->put('campaign',$value->count('camp_id'));
                    for($i = 0;$i < $value['count'];$i++)
                        $tmp[$value[$i]->camp_id]= $value->count('camp_id');
                        unset($value[$i]);
                    return $value;

                });
                arsort($tmp);
                dd($tmp);
                $charts['top5'] = $charts['top5']->sortByDesc('count')->groupBy('count')->map(function($value){
                        $value = $value->sortBy('time');
                        return $value;
                })->toArray();
                
                $charts['top5'] = $charts->flatten()->filter(function ($value, $key) {
                                    if(!is_numeric($value))
                                    return $value;
                                })->values()->toArray();
                $charts['countries'] = \App\subscribers::select(\DB::raw('country, COUNT( * ) AS count'))
                            ->wherein('email',$charts['top5'])
                            ->groupBy('country')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$charts['top5'])."')")->take(5)->get();
                $charts['state'] = \App\subscribers::select(\DB::raw('state, COUNT( * ) AS count'))
                            ->wherein('email',$charts['top5'])
                            ->groupBy('state')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$charts['top5'])."')")->take(5)->get();
                $charts['city'] = \App\subscribers::select(\DB::raw('city, COUNT( * ) AS count'))
                            ->wherein('email',$charts['top5'])
                            ->groupBy('city')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$charts['top5'])."')")->take(5)->get();            
                $charts['age'] = \App\subscribers::select(\DB::raw('age, COUNT( * ) AS count'))
                            ->wherein('email',$charts['top5'])
                            ->groupBy('age')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email,'".implode("','",$charts['top5'])."')")->take(5)->get();
                $charts['campaign'] = \App\activity::select(\DB::raw('camp_id, COUNT( * ) AS count'))
                            ->wherein('email_id',$charts['top5'])
                            ->groupBy('camp_id')
                            ->orderBy('count', 'desc')
                            ->orderByRaw("FIELD(email_id,'".implode("','",$charts['top5'])."')")->take(5)->get();  

                $charts['top5'] = \App\subscribers::select(\DB::raw('CONCAT(fname," ",mname," ",lname) as name'))
                            ->wherein('email',$charts['top5'])
                            ->orderByRaw("FIELD(email,'".implode("','",$charts['top5'])."')")->take(5)->get();
            
            
             
            return view('dashboard',['charts' => $charts]);
        }else{
            return redirect('connections');
        }
    }
}
