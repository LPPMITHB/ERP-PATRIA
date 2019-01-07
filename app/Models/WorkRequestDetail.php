<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkRequestDetail extends Model
{
    protected $table = 'trx_work_request_detail';

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }
}
