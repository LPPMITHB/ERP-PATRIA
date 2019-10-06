<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartDetailStandard extends Model
{
    protected $table = 'mst_part_detail_standard';

    
    public function materialStandard()
    {
        return $this->belongsTo('App\Models\MaterialStandard');
    }
}
