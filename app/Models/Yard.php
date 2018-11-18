<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yard extends Model
{
    protected $table = 'mst_yard';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function yardPlans()
    {
        return $this->hasMany('App\Models\YardPlan');
    }

}