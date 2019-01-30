<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceDetail extends Model
{
    protected $table = 'mst_resource_detail';

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function performanceUom()
    {
        return $this->belongsTo('App\Models\Uom', 'performance_uom_id');
    }

    public function goodsReceiptDetail()
    {
        return $this->hasOne('App\Models\GoodsReceiptDetail');
    }

    public function productionOrderDetails()
    {
        return $this->hasMany('App\Models\ProductionOrderDetail');
    }
}
