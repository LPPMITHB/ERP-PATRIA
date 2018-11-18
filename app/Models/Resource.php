<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'mst_resource';

    public function uom()
    {
        return $this->belongsTo('App\Models\Uom');
    }

    public function productionOrderDetails()
    {
        return $this->hasMany('App\Models\ProductionOrderDetail');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
