<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'mst_customer';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function projects() 
    {
        return $this->hasMany('App\Models\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}
