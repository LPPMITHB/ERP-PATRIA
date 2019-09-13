<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityControlTypeDetail extends Model
{
    protected $table = 'mst_quality_control_type_detail';

    public function qualityControlType()
    {
        return $this->belongsTo('App\Models\QualityControlType');
    }

    public function qualityControlTasks()
    {
        return $this->hasMany('App\Models\QualityControlTask');
    }
}
