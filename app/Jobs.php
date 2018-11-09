<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
   protected $fillable = ['job_id','client_id','property_id', 'user_id', 'description','type','date_started','date_ended','time_started','time_ended','internal_notes','invoicing', 'duration', 'duration_unit', 'billing_frequency', 'status', 'colsed_at'];
   public $timestamps = false;
}
