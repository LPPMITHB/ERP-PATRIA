<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityPlan extends Model
{
    //
    protected $table = 'mst_quality_plans';
    public function qualityPlanProject()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
