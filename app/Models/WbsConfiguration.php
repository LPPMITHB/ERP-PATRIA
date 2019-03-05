<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsConfiguration extends Model
{
    protected $table = 'mst_wbs_configuration';
  
    public function activities()
    {
        return $this->hasMany('App\Models\ActivityConfiguration', 'wbs_id');
    }

    public function wbssProject() 
    {
        return $this->hasMany('App\Models\WBS','wbs_configuration_id');
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
