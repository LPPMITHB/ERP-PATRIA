<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityConfiguration extends Model
{
    protected $table = 'mst_activity_configuration';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WbsConfiguration', 'wbs_id');
    }

    public function activitiesProject() 
    {
        return $this->hasMany('App\Models\Activity','activity_configuration_id');
    }
}
