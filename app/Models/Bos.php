<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bos extends Model
{
    protected $table = 'mst_bos';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function bosDetails()
    {
        return $this->hasMany('App\Models\BosDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS', 'wbs_id');
    }

    public function rap()
    {
        return $this->hasOne('App\Models\Rap');
    }
}
