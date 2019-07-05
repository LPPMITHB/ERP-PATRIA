<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReturn extends Model
{
    protected $table = 'trx_goods_return';

    public function goodsReturnDetails()
    {
        return $this->hasMany('App\Models\GoodsReturnDetail');
    }
    
    public function goodsReceipt()
    {
        return $this->belongsTo('App\Models\GoodsReceipt');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User','approved_by');
    }
}
