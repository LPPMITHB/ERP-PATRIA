<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $table = 'trx_sales_order';

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function salesOrderDetails() 
    {
        return $this->hasMany('App\Models\SalesOrderDetail');
    }
}
