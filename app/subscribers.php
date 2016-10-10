<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscribers extends Model
{
    //
    public $incrementing = false;
    protected $fillable = [
        'id','fname','mname',
        'lname','email','gender',
        'age','address','city',
        'country','state','zip',
        'rank','status','avg_open_rate',
        'avg_click_rate','list_id'
    ];

}
