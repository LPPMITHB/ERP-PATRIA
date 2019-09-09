<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'pro_project';
    
    public function projectStandard()
    {
        return $this->belongsTo('App\Models\ProjectStandard');
    }

    public function businessUnit()
    {
        return $this->belongsTo('App\Models\BusinessUnit');
    }

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

    public function wbss()
    {
        return $this->hasMany('App\Models\WBS');
    }

    public function purchaseRequisitions()
    {
        return $this->hasMany('App\Models\PurchaseRequisition');
    }

    public function materialRequisitions()
    {
        return $this->hasMany('App\Models\MaterialRequisition');
    }
    
    public function purchaseOrders()
    {
        return $this->hasMany('App\Models\PurchaseOrder');
    }

    public function raps()
    {
        return $this->hasMany('App\Models\Rap');
    }

    public function yardPlans()
    {
        return $this->hasMany('App\Models\YardPlan');
    }

    public function dailyManHours()
    {
        return $this->hasMany('App\Models\DailyManHour');
    }

    public function cost()
    {
        return $this->hasMany('App\Models\Cost');
    }

    public function salesOrder()
    {
        return $this->belongsTo('App\Models\SalesOrder');
    }

    public function qualityControlTasks()
    {
        return $this->hasMany('App\Models\QualityControlTask');
    }

    public function deliveryDocuments()
    {
        return $this->hasMany('App\Models\DeliveryDocument');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
}
