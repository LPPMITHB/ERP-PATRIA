<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsIssue extends Model
{
    protected $table = 'trx_goods_issue';
    
    public function materialRequisition()
    {
        return $this->belongsTo('App\Models\MaterialRequisition');
    }

    public function goodsIssueDetails()
    {
        return $this->hasMany('App\Models\GoodsIssueDetail');
    }
}
