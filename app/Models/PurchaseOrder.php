<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'trx_purchase_order';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function purchaseRequisition()
    {
        return $this->belongsTo('App\Models\PurchaseRequisition');
    }

    public function goodsReceipts()
    {
        return $this->hasMany('App\Models\GoodsReceipt');
    }

    public function purchaseOrderDetails()
    {
        return $this->hasMany('App\Models\PurchaseOrderDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User','approved_by');
    }
}
