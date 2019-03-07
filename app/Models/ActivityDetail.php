<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityDetail extends Model
{
    protected $table = 'pro_activity_detail';

    public function activity()
    {
        return $this->hasOne('App\Models\Activity');
    }

}
