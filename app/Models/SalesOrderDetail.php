<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    protected $table = 'trx_sales_order_detail';

    public function salesOrder()
    {
        return $this->belongsTo('App\Models\SalesOrder');
    }

    public function estimatorCostStandard() 
    {
        return $this->belongsTo('App\Models\EstimatorCostStandard','cost_standard_id');
    }
}
