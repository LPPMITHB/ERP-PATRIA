<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WBSImage extends Model
{
    protected $table = 'pro_wbs_images';

    public function wbs()
    {
        return $this->belongsTo(self::class, 'wbs_id');
    }
}
