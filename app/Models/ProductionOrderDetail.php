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
}
