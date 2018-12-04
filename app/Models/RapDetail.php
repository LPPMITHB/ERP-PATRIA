<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapDetail extends Model
{
    //
    protected $table = 'trx_rap_detail';
    
    public function rap()
    {
        return $this->belongsTo('App\Models\Rap');
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
