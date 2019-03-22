<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $table = 'mst_service_detail';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function boss()
    {
        return $this->hasMany('App\Models\Bos');
    }

    public function bosDetails()
    {
        return $this->hasMany('App\Models\BosDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function uom()
    {
        return $this->belongsTo('App\Models\Uom');
    }
    
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function activityDetails()
    {
        return $this->hasMany('App\Models\ActivityDetail');
    }

}
