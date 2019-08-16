<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStandard extends Model
{
    protected $table = 'mst_project_standard';

    public function ship()
    {
        return $this->belongsTo('App\Models\Ship');
    }

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
        return $this->hasMany('App\Models\WbsStandard');
    }

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
}
