<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'mst_stock';

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
