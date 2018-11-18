<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    public function menus() 
    {
        return $this->hasMany('App\Models\Menu');
    }

    public function sidenavs() 
    {
        return $this->hasMany('App\Models\Sidenav');
    }

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }
}
