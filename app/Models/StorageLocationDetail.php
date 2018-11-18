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
}
