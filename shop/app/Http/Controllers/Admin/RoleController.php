<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Services\RoleService;
use App\Services\PermissionService;

class RoleController extends Controller
{

    protected $roleService;
    protected $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService) 
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        if ($request->has('search')) {
            $roles = $this->roleService->searchRoles($searchTerm);
        }else {
            $roles = $this->roleService->getLatestRoles();
        }
        
        return view('admin.pages.role.index',compact('roles', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = $this->permissionService->getPermissionsGrouped();
        return view('admin.pages.role.create',['data' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $dataCreate = $request->all();
        $this->roleService->createRole($dataCreate);
        return redirect()->route('roles.index')->with('success', 'Create successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->roleService->getRoleById($id);
        return view('admin.pages.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = $this->roleService->getRoleWithPermissions($id);
        $permissions = $this->permissionService->getPermissionsGrouped();
        return view('admin.pages.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRoleRequest $request, string $id)
    {
        $dataUpdate = $request->all();
        $this->roleService->updateRole($id, $dataUpdate);
        return redirect()->route('roles.index')->with('success', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->roleService->deleteRole($id);
        return redirect()->route('roles.index')->with('success', 'Delete successfully');
    }
}
