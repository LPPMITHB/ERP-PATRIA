<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $table = 'trx_quotation_detail';

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }

    public function estimatorCostStandard() 
    {
        return $this->belongsTo('App\Models\EstimatorCostStandard','cost_standard_id');
    }
}
