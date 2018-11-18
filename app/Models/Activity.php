<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'pro_project_work_activity';

    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }

}
