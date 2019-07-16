<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyManHour extends Model
{
    protected $table = 'daily_man_hour';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
