<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomPrep extends Model
{
    protected $table = 'mst_bom_prep';

    public function bomDetails()
    {
        return $this->hasMany('App\Models\BomDetail');
    }

    public function activityDetails()
    {
        return $this->hasMany('App\Models\ActivityDetail');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }
}
