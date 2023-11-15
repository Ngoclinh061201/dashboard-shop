<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getLatestRoles()
    {
        $roles = $this->roleRepository->latestRoles();

        return $this->roleRepository->paginateRoles($roles, 5);
    }

    public function searchRoles($searchTerm){
        $roles = $this->roleRepository->searchRoles($searchTerm);
        return $this->roleRepository->paginateRoles($roles, 5);

    }

    public function createRole(array $data)
    {
        $role = $this->roleRepository->create($data);

        // Attach permissions to the role
        if (isset($data['permission_ids'])) {
            $role->permissions()->attach($data['permission_ids']);
        }

    }
    public function getRoleById(string $id)
    {
        return $this->roleRepository->getById($id);
    }
    public function getRoleWithPermissions(string $id)
    {
        return $this->roleRepository->getRoleWithPermissions($id);
    }
    public function updateRole(string $id, array $data)
    {
        $role = $this->roleRepository->getById($id);
        $this->roleRepository->update($role, $data);

        // Cập nhật quyền của vai trò
        if (isset($data['permission_ids'])) {
            $role->permissions()->sync($data['permission_ids']);
        }

    }
    public function deleteRole(string $id)
    {
        $role = $this->roleRepository->getById($id);
        $this->roleRepository->delete($role);

    }
}
