<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lists extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','name','user_id'];
}
