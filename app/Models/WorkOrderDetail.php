<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderDetail extends Model
{
    protected $table = 'trx_work_order_detail';
    
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function workRequestDetail()
    {
        return $this->belongsTo('App\Models\WorkRequestDetail');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }
    
    public function workOrder()
    {
        return $this->belongsTo('App\Models\WorkOrder');
    }
}
