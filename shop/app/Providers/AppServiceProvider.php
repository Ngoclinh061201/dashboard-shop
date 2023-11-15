<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\ServiceProvider;
use App\Repositories\RoleRepository;
use App\Services\RoleService;
use App\Models\Role;
use Illuminate\Pagination\Paginator;
use App\Repositories\PermissionRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // $this->app->bind(RoleRepository::class, function () {
        //     return new RoleRepository($this->app->make(Role::class));
        // });

        // $this->app->bind(RoleService::class, function ($app) {
        //     return new RoleService(
        //         $app->make(RoleRepository::class),
        //         $app->make(PermissionRepository::class)
        //     );
        // });

        // $this->app->bind(PermissionRepository::class, function ($app) {
        //     return new PermissionRepository($this->app->make(Permission::class));
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
