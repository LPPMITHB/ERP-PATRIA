<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceDetail extends Model
{
    protected $table = 'mst_resource_detail';

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }
}
