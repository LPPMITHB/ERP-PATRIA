<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'trx_quotation';

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function estimatorProfile() 
    {
        return $this->belongsTo('App\Models\EstimatorProfile','profile_id');
    }

    public function quotationDetails() 
    {
        return $this->hasMany('App\Models\QuotationDetail');
    }
}
