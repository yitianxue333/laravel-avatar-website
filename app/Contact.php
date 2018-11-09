<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'clients_contact';
    protected $fillable = ['contact_id	','client_id','type','option', 'value', 'is_primary'];
    public $timestamps = false;
    
}
