<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptDetail extends Model
{
    protected $table = 'trx_goods_receipt_detail';
    
    public function goodsReceipt()
    {
        return $this->belongsTo('App\Models\GoodsReceipt');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function resourceDetail()
    {
        return $this->belongsTo('App\Models\ResourceDetail');
    }

    public function storageLocation()
    {
        return $this->belongsTo('App\Models\StorageLocation');
    }

    public function storageLocationDetail()
    {
        return $this->hasOne('App\Models\StorageLocationDetail');
    }
}
