<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscribers extends Model
{
    //
    public $incrementing = false;
    protected $fillable = [
        'fname','lname',
        'email','gender',
        'age','city',
        'country','state',
        'zip',
    ];

}
