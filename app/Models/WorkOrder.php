<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'trx_work_order';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function workRequest()
    {
        return $this->belongsTo('App\Models\WorkRequest');
    }

    public function goodsReceipts()
    {
        return $this->hasMany('App\Models\GoodsReceipt');
    }

    public function workOrderDetails()
    {
        return $this->hasMany('App\Models\WorkOrderDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User','approved_by');
    }
}
