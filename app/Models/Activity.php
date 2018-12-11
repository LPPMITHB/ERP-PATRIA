<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'pro_activity';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS', 'wbs_id');
    }

}
