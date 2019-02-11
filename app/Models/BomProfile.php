<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomProfile extends Model
{
    protected $table = 'mst_bom_profile';

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

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WbsProfile', 'wbs_id');
    }
}
