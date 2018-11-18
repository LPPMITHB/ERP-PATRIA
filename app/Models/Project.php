<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'pro_project';
    
    public function ship()
    {
        return $this->belongsTo('App\Models\Ship');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function boms()
    {
        return $this->hasMany('App\Models\Bom');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function works()
    {
        return $this->hasMany('App\Models\Work');
    }

    public function PurchaseRequisition()
    {
        return $this->hasMany('App\Models\PurchaseRequisition');
    }
    
    public function PurchaseOrder()
    {
        return $this->hasMany('App\Models\PurchaseOrder');
    }

    public function Rabs()
    {
        return $this->hasMany('App\Models\Rab');
    }

    public function yardPlans()
    {
        return $this->hasMany('App\Models\YardPlan');
    }
}
