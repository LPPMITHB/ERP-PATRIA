<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsMaterial extends Model
{
    protected $table = 'pro_wbs_material';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function dimensionUom()
    {
        return $this->belongsTo('App\Models\Uom','dimension_uom_id');
    }

    public function areaUom()
    {
        return $this->belongsTo('App\Models\Uom','area_uom_id');
    }

    public function serviceDetail()
    {
        return $this->belongsTo('App\Models\ServiceDetail');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function bomPrep()
    {
        return $this->belongsTo('App\Models\BomPrep');
    }
}
