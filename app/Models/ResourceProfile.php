<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceProfile extends Model
{
    protected $table = 'mst_resource_profile';

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function resourceDetail()
    {
        return $this->belongsTo('App\Models\ResourceDetail');
    }
}
