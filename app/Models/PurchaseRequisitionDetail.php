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

    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }
}
