<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDocument extends Model
{
    protected $table = 'pro_delivery_document';

    public function project() 
    {
        return $this->belongsTo('App\Models\Project');
    }
}
