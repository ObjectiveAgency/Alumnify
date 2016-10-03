<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class campaigns extends Model
{

	    public $incrementing = false;
    protected $fillable = ['id','name','status','email_sent','list_id'];

}
