<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model
{
    protected $table = 'trx_production_order_detail';

    public function productionOrder()
    {
        return $this->belongsTo('App\Models\ProductionOrder');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
  
    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function productionOrderDetails()
    {
        return $this->hasMany('App\Models\ProductionOrderDetail');
    }

    public function resourceDetail()
    {
        return $this->belongsTo('App\Models\ResourceDetail');
    }

    public function performanceUom()
    {
        return $this->belongsTo('App\Models\Uom', 'performance_uom_id');
    }
}
