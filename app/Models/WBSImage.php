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
}
