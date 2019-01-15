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
}
