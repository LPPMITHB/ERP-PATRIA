<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    protected $table = 'mst_business_unit';

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
}
