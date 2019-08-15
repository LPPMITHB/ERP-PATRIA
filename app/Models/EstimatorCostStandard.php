<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimatorCostStandard extends Model
{
    protected $table = 'mst_estimator_cost_standard';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function estimatorWbs()
    {
        return $this->belongsTo('App\Models\EstimatorWbs');
    }

    public function uom()
    {
        return $this->belongsTo('App\Models\Uom');
    }

    public function estimatorProfileDetails() 
    {
        return $this->hasMany('App\Models\EstimatorProfileDetail','cost_standard_id');
    }
}
