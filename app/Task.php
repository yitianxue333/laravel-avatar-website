<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'description', 
        'date_started', 
        'time_started', 
        'date_ended', 
        'time_ended', 
        'is_allday', 
        'repeat', 
        'teams', 
        'user_id',
        'is_complete',
        'date_completed',
        'job_id',
        'client_id'
    ];

    public $timestamps = false;

}
