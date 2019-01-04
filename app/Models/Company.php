<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'mst_company';

    public function branches()
    {
        return $this->hasMany('App\Models\Branch');
    }
}
