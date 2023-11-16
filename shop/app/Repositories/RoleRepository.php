<?php
namespace App\Repositories;

use App\Models\Role;


class RoleRepository
{
    protected $roles;

    public function __construct(Role $roles)
    {
        $this->roles = $roles;
    }

    public function searchRoles($searchTerm)
    {
        return $this->roles->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('display_name', 'like', '%' . $searchTerm . '%');
    }

    public function latestRoles()
    {
        return $this->roles->latest('updated_at');
    }

    public function paginateRoles($roles, $perPage)
    {
        return $roles->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->roles->create($data);
    }

    public function getById(string $id)
    {
        return $this->roles->findOrFail($id);
    }

    public function getRoleWithPermissions(string $id)
    {
        return $this->roles->with('permissions')->findOrFail($id);
    }

    public function update(Role $role, array $data)
    {
        $role->update($data);
    }
    
    public function delete(Role $role)
    {
        $role->delete();
    }
    public function getRoles()
    {
        return $this->roles->all();
    }
}
