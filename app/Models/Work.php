<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = 'pro_project_work';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
  
    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }

    public function works() 
    {
        return $this->hasMany(self::class);
    }

    public function work()
    {
        return $this->belongsTo(self::class);
    }

    public function bom()
    {
        return $this->hasOne('App\Models\Bom');
    }

    public function yardPlans()
    {
        return $this->hasMany('App\Models\YardPlan');
    }

    public function resourceDetails()
    {
        return $this->hasMany('App\Models\ResourceDetail');
    }

    public function materialRequisitionDetails()
    {
        return $this->hasMany('App\Models\MaterialRequisitionDetail');
    }
}
