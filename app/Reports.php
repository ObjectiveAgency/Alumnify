<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id','campaign',
    	'list_id','emails_sent',
        'abuse_reports','unsubscribe',
        'hard_bounce','soft_bounce',
        'opens_total','unique_opens',
        'open_rate','clicks_total',
        'unique_clicks','unique_subscriber_clicks',
        'click_rate','sub_rate',
        'unsub_rate','list_open_rate',
        'list_click_rate'
    ];
}
