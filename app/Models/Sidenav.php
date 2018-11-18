<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sidenav extends Model
{
    protected $table = 'sidenav';

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }
}
