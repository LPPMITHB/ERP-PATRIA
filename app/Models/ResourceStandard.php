<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceStandard extends Model
{
    protected $table = 'mst_resource_standard';
    
    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
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
