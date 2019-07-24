<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReverseTransaction extends Model
{
    protected $table = 'trx_reverse_transaction';
    
    public function reverseTransactionDetails()
    {
        return $this->hasMany('App\Models\ReverseTransactionDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User','approved_by');
    }
}
