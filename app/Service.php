<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $table = 'services';
    protected $fillable = ['service_id','name','type','description', 'unit', 'exempt', 'user_id', 'sort'];
    public $timestamps = false;
   
}
