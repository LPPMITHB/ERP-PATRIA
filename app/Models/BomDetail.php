<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomDetail extends Model
{
    protected $table = 'mst_bom_detail';

    public function bom()
    {
        return $this->belongsTo('App\Models\Bom');
    }

    public function bomPrep()
    {
        return $this->belongsTo('App\Models\BomPrep');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
