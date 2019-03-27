<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WBS extends Model
{
    protected $table = 'pro_wbs';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
  
    public function activities()
    {
        return $this->hasMany('App\Models\Activity', 'wbs_id');
    }

    public function wbss() 
    {
        return $this->hasMany(self::class, 'wbs_id');
    }

    public function wbs()
    {
        return $this->belongsTo(self::class, 'wbs_id');
    }

    public function wbsConfig()
    {
        return $this->belongsTo('App\Models\WbsConfiguration', 'wbs_configuration_id');
    }

    public function bom()
    {
        return $this->hasOne('App\Models\Bom', 'wbs_id');
    }

    public function yardPlans()
    {
        return $this->hasMany('App\Models\YardPlan');
    }

    public function resourceDetails()
    {
        return $this->hasMany('App\Models\ResourceDetail');
    }

    public function resourceTrxs()
    {
        return $this->hasMany('App\Models\ResourceTrx', 'wbs_id');
    }

    public function materialRequisitionDetails()
    {
        return $this->hasMany('App\Models\MaterialRequisitionDetail', 'wbs_id');
    }

    public function productionOrder()
    {
        return $this->hasOne('App\Models\ProductionOrder', 'wbs_id');
    }

    public function goodsReceipt()
    {
        return $this->hasOne('App\Models\GoodsReceipt', 'wbs_id');
    }
}
