<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rap extends Model
{
    protected $table = 'trx_rap';
    
    public function rapDetails()
    {
        return $this->hasMany('App\Models\RapDetail');
    }
    
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function bom()
    {
        return $this->belongsTo('App\Models\Bom');
    }

}
