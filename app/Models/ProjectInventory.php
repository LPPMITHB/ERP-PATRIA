<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInventory extends Model
{
    protected $table = 'trx_project_inventory';
    
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
