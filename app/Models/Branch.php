<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'mst_branch';

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function vendors()
    {
        return $this->hasMany('App\Models\Vendor');
    }
}
