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
       //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
