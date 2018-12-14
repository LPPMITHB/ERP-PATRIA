<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BosDetail extends Model
{
    protected $table = 'mst_bos_detail';

    public function bos()
    {
        return $this->belongsTo('App\Models\Bos');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function user()
    {
        return $this->belongsTo('App\Branch');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
