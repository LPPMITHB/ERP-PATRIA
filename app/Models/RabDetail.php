<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RabDetail extends Model
{
    //
    protected $table = 'ref_rab_detail';
    
    public function rab()
    {
        return $this->belongsTo('App\Models\RAB');
    }
    
    public function bom()
    {
        return $this->belongsTo('App\Models\Bom');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }
}
