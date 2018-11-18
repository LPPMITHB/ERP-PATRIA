<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SnapshotDetail extends Model
{
    protected $table = 'ref_snapshot_detail';
 
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function storageLocation()
    {
        return $this->belongsTo('App\Models\StorageLocation');
    }

    public function snapshot()
    {
        return $this->belongsTo('App\Models\Snapshot');
    }
}
