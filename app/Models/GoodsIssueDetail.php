<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsIssueDetail extends Model
{
    protected $table = 'trx_goods_issue_detail';
    
    public function goodsIssue()
    {
        return $this->belongsTo('App\Models\GoodsIssue');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function storageLocation()
    {
        return $this->belongsTo('App\Models\StorageLocation');
    }

    public function resourceDetail()
    {
        return $this->belongsTo('App\Models\ResourceDetail');
    }
}
