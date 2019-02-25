<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsProfile extends Model
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

    public function bom()
    {
        return $this->hasMany('App\Models\BomProfile', 'wbs_id');
    }

    public function resources()
    {
        return $this->hasMany('App\Models\ResourceProfile', 'wbs_id');
    }
}
