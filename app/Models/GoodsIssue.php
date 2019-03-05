<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsIssue extends Model
{
    protected $table = 'trx_goods_issue';
    
    public function materialRequisition()
    {
        return $this->belongsTo('App\Models\MaterialRequisition');
    }

    public function goodsIssueDetails()
    {
        return $this->hasMany('App\Models\GoodsIssueDetail');
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
}
