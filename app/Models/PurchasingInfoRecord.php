<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasingInfoRecord extends Model
{
    protected $table = 'purchasing_info_record';
    
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function purchaseRequisition()
    {
        return $this->belongsTo('App\Models\PurchaseRequisition');
    }

    public function purchaseRequisitionDetail()
    {
        return $this->belongsTo('App\Models\PurchaseRequisitionDetail');
    }
}
