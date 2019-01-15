<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'mst_vendor';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function resources()
    {
        return $this->hasMany('App\Models\Resource');
    }

    public function purchaseOrder()
    {
        return $this->hasMany('App\Models\PurchaseOrder');
    }

}
