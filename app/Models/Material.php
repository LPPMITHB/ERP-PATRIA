<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'mst_material';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function boms()
    {
        return $this->hasMany('App\Models\Bom');
    }

    public function bomDetails()
    {
        return $this->hasMany('App\Models\BomDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function uom()
    {
        return $this->belongsTo('App\Models\Uom','uom_id');
    }

    public function weightUom()
    {
        return $this->belongsTo('App\Models\Uom','weight_uom_id');
    }

    public function dimensionUom()
    {
        return $this->belongsTo('App\Models\Uom','dimension_uom_id');
    }
    
    public function RapDetails()
    {
        return $this->hasMany('App\Models\RapDetail');
    }

    public function stock()
    {
        return $this->hasOne('App\Models\Stock');
    }

    public function snapshotDetails()
    {
        return $this->hasMany('App\Models\SnapshotDetail');
    }

    public function PurchaseRequisitionDetails()
    {
        return $this->hasMany('App\Models\PurchaseRequisitionDetail');
    }

    public function PurchaseOrderDetails()
    {
        return $this->hasMany('App\Models\PurchaseOrderDetail');
    }

    public function goodsReceiptDetails()
    {
        return $this->hasMany('App\Models\GoodsReceiptDetail');
    }

    public function goodsIssueDetails()
    {
        return $this->hasMany('App\Models\GoodsIssueDetail');
    }

    public function materialRequisitionDetails()
    {
        return $this->hasMany('App\Models\MaterialRequisitionDetail');
    }

    public function goodsReturnDetails()
    {
        return $this->hasMany('App\Models\GoodsReturnDetail');
    }

    public function materialWriteOffDetails()
    {
        return $this->hasMany('App\Models\MaterialWriteOffDetail');
    }

    public function goodsMovementDetails()
    {
        return $this->hasMany('App\Models\GoodsMovementDetail');
    }

    public function productionOrderDetails()
    {
        return $this->hasMany('App\Models\ProductionOrderDetail');
    }

    public function storageLocationDetails()
    {    
        return $this->hasMany('App\Models\StorageLocationDetail');
    }
}
