<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsMovementDetail extends Model
{
    protected $table = 'trx_goods_movement_detail';

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }
}
