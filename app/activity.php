<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
	protected $fillable = ['camp_id','open','sent','email_id','list_id'];
    protected $table = 'activity';
    public $timestamps = false;


    // public function setOpenAttributes($value){
    // 	$this->attributes['open'] = date("Y-m-d H:i:s",strtotime($value));
    // }
}
