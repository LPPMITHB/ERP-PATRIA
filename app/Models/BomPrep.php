<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomPre extends Model
{
    protected $table = 'mst_bom_prep';

    public function bomDetails()
    {
        return $this->hasMany('App\Models\BomDetail');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }
}
