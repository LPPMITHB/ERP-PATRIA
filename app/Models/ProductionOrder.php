<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    protected $table = 'trx_production_order';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function ProductionOrderDetails()
    {
        return $this->hasMany('App\Models\ProductionOrderDetail');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }
  
}
