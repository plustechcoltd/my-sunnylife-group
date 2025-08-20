<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Admin;
use App\Models\AdminPermission;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies();

        if (!app()->runningInConsole()) {
            $this->defineAdminPermissions($gate);
        }

        // Auth::provider('custom_auth', function($app, array $config) {
        //     return new CustomAuthServiceProvider($this->app['hash'], $config['model']);
        // });
    }

    private function defineAdminPermissions(Gate $gate)
    {
        $admin_permissions = AdminPermission::all();
        foreach ($admin_permissions as $admin_permission) {
            $gate->define($admin_permission->name, function ($admin) use ($admin_permission) {
                if ($admin instanceof Admin) {
                    return $admin->hasPermission($admin_permission->name);
                }

                return false;
            });
        }
    }
}
