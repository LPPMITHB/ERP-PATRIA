<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVisit extends Model
{
    protected $table = 'trx_customer_visit';

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
