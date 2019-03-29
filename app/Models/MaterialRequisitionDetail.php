<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequisitionDetail extends Model
{
    protected $table = 'trx_material_requisition_detail';
    
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }

    public function material_requisition()
    {
        return $this->belongsTo('App\Models\MaterialRequisition');
    }
}
