<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approved extends Model
{
   protected $table = 'timesheets_approve';
   protected $fillable = ['approve_id','timesheets_id','date', 'day', 'hours','expenses', 'status', 'user_id', 'save_date','member_id'];
   public $timestamps = false;
}
