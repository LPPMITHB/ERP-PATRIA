<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualityControlTaskDetail extends Model
{
    public function qualityControlTask()
    {
        return $this->belongsTo('App\Models\qualityControlTask');
    }
}
