<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkRequest extends Model
{
    protected $table = 'trx_work_request';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function workRequestDetails()
    {
        return $this->hasMany('App\Models\WorkRequestDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User','approved_by');
    }
}
