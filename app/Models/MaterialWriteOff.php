<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialWriteOff extends Model
{
    protected $table = 'trx_material_write_off';
    
    public function materialWriteOffDetails()
    {
        return $this->hasMany('App\Models\MaterialWriteOffDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User','approved_by');
    }
}
