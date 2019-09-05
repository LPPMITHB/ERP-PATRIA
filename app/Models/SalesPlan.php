<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPlan extends Model
{
    protected $table = 'trx_sales_plan';

    public function ship()
    {
        return $this->belongsTo('App\Models\Ship');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
