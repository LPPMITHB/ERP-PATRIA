<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'mst_category';

    public function resources()
    {
        return $this->hasMany('App\Models\Resource');
    }

    public function resourceDetails()
    {
        return $this->hasMany('App\Models\ResourceDetail');
    }
}
