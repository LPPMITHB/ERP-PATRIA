<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectStandard extends Model
{
    protected $table = 'mst_project_standard';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function wbss()
    {
        return $this->hasMany('App\Models\WBS');
    }
}
