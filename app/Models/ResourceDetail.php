<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceDetail extends Model
{
    protected $table = 'mst_resource_detail';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }



    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
