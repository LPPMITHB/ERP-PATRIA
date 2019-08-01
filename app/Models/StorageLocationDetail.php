<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageLocationDetail extends Model
{
    protected $table = 'mst_storage_location_detail';

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function storageLocation()
    {
        return $this->belongsTo('App\Models\StorageLocation');
    }

    public function goodsReceiptDetail()
    {
        return $this->belongsTo('App\Models\GoodsReceiptDetail','goods_receipt_detail_id');
    }
}
