<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    public $permission;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->middleware, function ($user) use ($permission) {
                return $user->hasAccess([$permission->middleware]);
            });
        }
        $this->registerPolicies();
    }
}
