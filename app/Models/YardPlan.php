<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YardPlan extends Model
{
    protected $table = 'trx_yard_plan';

    public function yard()
    {
        return $this->belongsTo('App\Models\Yard');
    }
  
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }
}
