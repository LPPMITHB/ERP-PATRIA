<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsMovement extends Model
{
    protected $table = 'trx_goods_movement';
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function storageLocationFrom()
    {
        return $this->belongsTo('App\Models\StorageLocation','storage_location_from_id');
    }

    public function storageLocationTo()
    {
        return $this->belongsTo('App\Models\StorageLocation','storage_location_to_id');
    }

    public function goodsMovementDetails()
    {
        return $this->hasMany('App\Models\GoodsMovementDetail');
    }
    
}
