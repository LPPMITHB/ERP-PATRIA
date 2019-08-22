<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialStandard extends Model
{
    protected $table = 'mst_material_standard';
    
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WbsStandard', 'wbs_standard_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\ProjectStandard');
    }

}
