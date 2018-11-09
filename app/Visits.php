<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
	protected $table = 'visits';
    protected $fillable = ['visit_id','job_id','job_type','start_date','end_date','start_time','end_time','status','completed_by','completed_on','created_at','updated_at'];
    public $timestamps = true;
   
}
