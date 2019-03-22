<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityDetail extends Model
{
    protected $table = 'pro_activity_detail';

    public function activity()
    {
        return $this->belongsTo('App\Models\Activity');
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
