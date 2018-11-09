<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	protected $table = 'clients_properties';
    protected $fillable = ['property_id	','client_id','street1','street2', 'city', 'state','zip_code','country','type','tax','latitude','longitude'];
    public $timestamps = false;
   
}
