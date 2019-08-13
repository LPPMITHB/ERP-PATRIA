<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    protected $table = 'mst_uom';

    public function resources()
    {
        return $this->hasMany('App\Models\Resource');
    }

    public function costStandards()
    {
        return $this->hasMany('App\Models\EstimateCostStandard');
    }
}
