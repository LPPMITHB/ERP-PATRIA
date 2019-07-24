<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReverseTransactionDetail extends Model
{
    protected $table = 'trx_reverse_transaction_detail';
    
    public function reverseTransaction()
    {
        return $this->belongsTo('App\Models\ReverseTransaction');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }
}
