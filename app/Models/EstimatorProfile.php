<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimatorProfile extends Model
{
    protected $table = 'mst_estimator_profile';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ship()
    {
        return $this->belongsTo('App\Models\Ship');
    }

    public function estimatorProfileDetails() 
    {
        return $this->hasMany('App\Models\EstimatorProfileDetail','cost_standard_id');
    }
}
