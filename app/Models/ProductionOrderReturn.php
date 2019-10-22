<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderReturn extends Model
{
    protected $table = 'trx_production_order_return';

    public function bomDetail()
    {
        return $this->belongsTo('App\Models\BomDetail');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function productionOrderDetail()
    {
        return $this->belongsTo('App\Models\ProductionOrderDetail');
    }

    public function storageLocation()
    {
        return $this->belongsTo('App\Models\StorageLocation');
    }
}
