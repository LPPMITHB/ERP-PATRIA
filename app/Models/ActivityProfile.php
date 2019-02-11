<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityProfile extends Model
{
    protected $table = 'mst_activity_profile';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WbsProfile', 'wbs_id');
    }

}
