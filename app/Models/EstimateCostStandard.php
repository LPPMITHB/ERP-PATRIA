<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimateCostStandard extends Model
{
    protected $table = 'mst_estimate_cost_standard';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function estimateWbs()
    {
        return $this->belongsTo('App\Models\EstimateWbs');
    }

    public function uom()
    {
        return $this->belongsTo('App\Models\Uom');
    }
}
