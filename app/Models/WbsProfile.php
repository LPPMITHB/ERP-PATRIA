<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WBS extends Model
{
    protected $table = 'mst_wbs_profile';
  
    public function activities()
    {
        return $this->hasMany('App\Models\ActivityProfile', 'wbs_id');
    }

    public function wbss() 
    {
        return $this->hasMany(self::class, 'wbs_id');
    }

    public function wbs()
    {
        return $this->belongsTo(self::class, 'wbs_id');
    }
}
