<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderUpload extends Model
{
    protected $table = 'trx_production_order_upload';

    public function productionOrder()
    {
        return $this->belongsTo('App\Models\ProductionOrder');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
