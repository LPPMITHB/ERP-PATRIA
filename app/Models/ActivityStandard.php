<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityStandard extends Model
{
    protected $table = 'mst_activity_standard';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WbsStandard', 'wbs_id');
    }

    public function activitiesProject() 
    {
        return $this->hasMany('App\Models\Activity','activity_standard_id');
    }
}
