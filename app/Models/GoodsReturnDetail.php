<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReturnDetail extends Model
{
    protected $table = 'trx_goods_return_detail';

    public function goodsReturn()
    {
        return $this->belongsTo('App\Models\GoodsReturn');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function storageLocation()
    {
        return $this->belongsTo('App\Models\StorageLocation');
    }
}
