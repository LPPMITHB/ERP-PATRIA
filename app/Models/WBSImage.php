<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WBSImage extends Model
{
    protected $table = 'pro_wbs_images';

    public function wbs()
    {
        return $this->belongsTo('App\Models\WBS','wbs_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch','branch_id');
    }
}
