<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    protected $table = 'ref_snapshot';

    public function user()
    {
        return $this->belongsTo('App\Branch');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function snapshotDetails()
    {
        return $this->hasMany('App\Models\SnapshotDetail');
    }
}
