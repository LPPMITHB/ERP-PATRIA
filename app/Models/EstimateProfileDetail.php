<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimateProfileDetail extends Model
{
    protected $table = 'mst_estimate_profile_detail';

    public function estimateProfile() 
    {
        return $this->belongsTo('App\Models\EstimateProfile','profile_id');
    }

    public function estimateCostStandard() 
    {
        return $this->belongsTo('App\Models\EstimateCostStandard','cost_standard_id');
    }
}
