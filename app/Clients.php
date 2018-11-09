<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
   protected $fillable = ['client_id','first_name','last_name', 'company', 'use_company','user_id','created_at'];
   public $timestamps = false;
}
