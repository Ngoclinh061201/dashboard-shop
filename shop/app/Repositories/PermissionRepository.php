<?php
namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    protected $permissions;

    public function __construct(Permission $permissions){
        $this->permissions = $permissions;
    }
    
    public function all()
    {
        return $this->permissions->all();
    }





}