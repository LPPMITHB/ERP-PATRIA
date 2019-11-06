<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'pro_activity';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS', 'wbs_id');
    }
    
    public function activityDetails()
    {
        return $this->hasMany('App\Models\ActivityDetail');
    }

    public function wbsMaterial()
    {
        return $this->hasOne('App\Models\WbsMaterial');
    }
}
