<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimatorProfileDetail extends Model
{
    protected $table = 'mst_estimator_profile_detail';

    public function estimatorProfile() 
    {
        return $this->belongsTo('App\Models\EstimatorProfile','profile_id');
    }

    public function estimatorCostStandard() 
    {
        return $this->belongsTo('App\Models\EstimatorCostStandard','cost_standard_id');
    }
}
