<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Model
{
    protected $table = 'mst_storage_location';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }
    
    public function snapshotDetails()
    {
        return $this->hasMany('App\Models\SnapshotDetail');
    }

    public function storageLocationDetails()
    {
        return $this->hasMany('App\Models\StorageLocationDetail');
    }

    public function goodsIssueDetails()
    {
        return $this->hasMany('App\Models\GoodsIssueDetail');
    }
    
    public function goodsReceiptDetails()
    {
        return $this->hasMany('App\Models\GoodsReceiptDetail');
    }
}
