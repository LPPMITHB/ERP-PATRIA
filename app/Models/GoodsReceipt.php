<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    protected $table = 'trx_goods_receipt';
    
    public function purchaseOrder()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    public function goodsReceiptDetails()
    {
        return $this->hasMany('App\Models\GoodsReceiptDetail');
    }

    public function materials()
    {
        return $this->hasMany('App\Models\Material');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
}
