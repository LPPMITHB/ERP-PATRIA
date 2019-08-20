<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsStandard extends Model
{
    protected $table = 'mst_wbs_standard';
  
    public function materialStandards()
    {
        return $this->hasMany('App\Models\MaterialStandard', 'wbs_standard_id');
    }

    public function activities()
    {
        return $this->hasMany('App\Models\ActivityStandard', 'wbs_id');
    }

    public function wbssProject() 
    {
        return $this->hasMany('App\Models\WBS','wbs_standard_id');
    }

    public function wbss() 
    {
        return $this->hasMany(self::class, 'wbs_id');
    }

    public function wbs()
    {
        return $this->belongsTo(self::class, 'wbs_id');
    }

    public function projectStandard() 
    {
        return $this->belongsTo('App\Models\ProjectStandard');
    }

}
