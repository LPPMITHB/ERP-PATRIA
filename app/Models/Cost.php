<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $table = 'trx_rap_other_cost';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
