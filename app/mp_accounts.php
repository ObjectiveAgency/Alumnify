<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mp_accounts extends Model
{
      public $incrementing = false;
    protected $fillable = ['id','email','username'];
}
