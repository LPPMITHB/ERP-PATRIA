<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceTrx extends Model
{
   protected $table = 'trx_resource';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function resourceDetail()
    {
        return $this->belongsTo('App\Models\ResourceDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
