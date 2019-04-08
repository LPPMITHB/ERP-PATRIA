<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'trx_purchase_order_detail';
    
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function purchaseRequisitionDetail()
    {
        return $this->belongsTo('App\Models\PurchaseRequisitionDetail');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }
    
    public function purchaseOrder()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }
    
    public function activityDetail()
    {
        return $this->belongsTo('App\Models\ActivityDetail');
    }
}
