<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityControlTaskDetail extends Model
{

    protected $table = 'trx_quality_control_task_detail';

    public function qualityControlTask()
    {
        return $this->belongsTo('App\Models\QualityControlTask');
    }
}
