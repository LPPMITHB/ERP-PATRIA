<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisitionDetail extends Model
{
    protected $table = 'trx_purchase_requisition_detail';

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function purchaseRequisition()
    {
        return $this->belongsTo('App\Models\PurchaseRequisition');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function activityDetail()
    {
        return $this->belongsTo('App\Models\ActivityDetail');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
}
