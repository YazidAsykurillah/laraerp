<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // Dynamically register permissions with Laravel's Gate.
<<<<<<< HEAD
       foreach ($this->getPermissions() as $permission) {
=======
        foreach ($this->getPermissions() as $permission) {
>>>>>>> 74cc9444a2f789c504dd41f4a84bf61f4d07da9e
            $gate->define($permission->slug, function ($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }
    }


    protected function getPermissions(){

        return Permission::with('roles')->get();
    }
}
