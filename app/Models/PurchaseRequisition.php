<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisition extends Model
{
    protected $table = 'trx_purchase_requisition';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function purchaseRequisitionDetails()
    {
        return $this->hasMany('App\Models\PurchaseRequisitionDetail');
    }

    public function purchaseOrders()
    {
        return $this->hasMany('App\Models\PurchaseOrder');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function businessUnit()
    {
        return $this->belongsTo('App\Models\BusinessUnit');
    }

    public function bom()
    {
        return $this->belongsTo('App\Models\Bom');
    }

    public function approvedBy1()
    {
        return $this->belongsTo('App\Models\User','approved_by_1');
    }

    public function approvedBy2()
    {
        return $this->belongsTo('App\Models\User','approved_by_2');
    }

    public function roleApproved1()
    {
        return $this->belongsTo('App\Models\Role','role_approve_1');
    }

    public function roleApproved2()
    {
        return $this->belongsTo('App\Models\Role','role_approve_2');
    }
}
