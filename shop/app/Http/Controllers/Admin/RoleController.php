<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Requests\Role\CreateRoleREquest;

class RoleController extends Controller
{

    private $result;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest('updated_at')->paginate(5);
        return view('admin.pages.role.index',['data' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group');

        return view('admin.pages.role.create',['data' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleREquest $request)
    {
        $dataCreate = $request->all();
   
        $role = Role::create($dataCreate);
        
        $role->permissions()->attach($dataCreate['permission_ids']);
        return to_route('roles.index')->with(['message'=>'success create']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role=
        return view('admin.pages.role.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
