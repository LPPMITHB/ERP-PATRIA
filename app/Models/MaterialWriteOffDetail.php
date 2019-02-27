<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialWriteOffDetail extends Model
{
    protected $table = 'trx_material_write_off_detail';

    public function materialWriteOff()
    {
        return $this->belongsTo('App\Models\MaterialWriteOff');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function storageLocation()
    {
        return $this->belongsTo('App\Models\StorageLocation');
    }
    
}
