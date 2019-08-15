<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    protected $table = 'ref_snapshot';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * updatedBy Relationship function
     * untuk membuat relasi dengan tabel user
     * @return void
     */
    public function updatedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

    /**
     * auditedBy Relationship function
     * untuk membuat relasi dengan tabel user
     * @return void
     */
    public function auditedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'audited_by');
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
