<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
	protected $table = 'taxes';
    protected $fillable = ['tax_id','name','value','value', 'is_default'];
    public $timestamps = false;
   
}
