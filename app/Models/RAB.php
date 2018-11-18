<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    protected $table = 'ref_rab';
    
    public function RabDetails()
    {
        return $this->hasMany('App\Models\RabDetail');
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

}
