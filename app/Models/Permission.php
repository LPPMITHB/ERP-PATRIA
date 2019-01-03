<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
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
