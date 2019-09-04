<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'pro_post';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User');
    }
}
