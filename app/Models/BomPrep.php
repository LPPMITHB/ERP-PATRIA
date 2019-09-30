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

    public function wbsMaterials()
    {
        return $this->hasMany('App\Models\WbsMaterial');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }
}
