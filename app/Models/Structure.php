<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $table = 'mst_structure';

    public function boms()
    {
        return $this->hasMany('App\Models\Bom');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function structure()
    {
        return $this->belongsTo('App\Models\Structure');
    }

    public function structures()
    {
        return $this->hasMany('App\Models\Structure');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
