<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'mst_service';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function boss()
    {
        return $this->hasMany('App\Models\Bos');
    }

    public function bosDetails()
    {
        return $this->hasMany('App\Models\BosDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}
