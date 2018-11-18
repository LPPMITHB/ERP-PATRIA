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

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function user()
    {
        return $this->belongsTo('App\Branch');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
