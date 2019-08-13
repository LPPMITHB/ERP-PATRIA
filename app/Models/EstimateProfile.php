<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimateProfile extends Model
{
    protected $table = 'mst_estimate_profile';

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ship()
    {
        return $this->belongsTo('App\Models\Ship');
    }
}
