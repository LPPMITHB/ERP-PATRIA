<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequisition extends Model
{
    protected $table = 'trx_material_requisition';
 
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function MaterialRequisitionDetails()
    {
        return $this->hasMany('App\Models\MaterialRequisitionDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
