<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;

class PermissionService{
    protected $permissionRepository;
    
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }
    
    public function getPermissionsGrouped()
    {
        return $this->permissionRepository->all()->groupBy('group');
    }
}