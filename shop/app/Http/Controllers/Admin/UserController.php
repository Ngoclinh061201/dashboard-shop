<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;
    protected $roleService;
    public function __construct( UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        if ($request->has('search')) {
            $users = $this->userService->searchUsers($searchTerm);
            
        }else {
            $users = $this->userService->getLatestUsers();
        }
        
        return view('admin.pages.user.index',compact('users', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleService->getRoles()->groupBy('group');
        return view('admin.pages.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        
        $this->userService->createUser($request);
        return redirect()->route('users.index')->with('success', 'Create successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);
        return view('admin.pages.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $user = $this->userService->getUserWithRoles($id);
       
        $roles = $this->roleService->getRoles()->groupBy('group');
        
        return view('admin.pages.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        // dd($request->all());
        $user = $this->userService->updateUser($id, $request);
        return redirect()->route('users.index')->with('success', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'Delete successfully');
    }
}
