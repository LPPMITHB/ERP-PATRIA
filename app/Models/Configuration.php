<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'mst_configuration';

    public static function get($slug){
        $configuration = Configuration::where('slug', $slug)->firstOrFail();
        
        return json_decode($configuration->value);
    }
}
