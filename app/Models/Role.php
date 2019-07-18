<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable=[ 'name','description','permissions'];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function hasAccess(array $permissions)
    {
        foreach($permissions as $permission){
            if($this->hasPermission($permission)){
                return true;
            }
        }
        return false;
    }

    protected function hasPermission(string $permission)
    {
        $permissions = json_decode($this->permissions,true);
        
    	return $permissions[$permission]??false;
    }
}
