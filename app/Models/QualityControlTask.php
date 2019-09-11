<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityControlTask extends Model
{

    protected $table = 'trx_quality_control_task';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS', 'wbs_id');
    }

    public function qualityControlType()
    {
        return $this->belongsTo('App\Models\QualityControlType');
    }

    public function qualityControlTaskDetails()
    {
        return $this->hasMany('App\Models\QualityControlTaskDetail');
    }

}
