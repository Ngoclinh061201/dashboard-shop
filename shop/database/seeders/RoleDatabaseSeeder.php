<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name'=> 'super-admin', 'display_name' => 'Super Admin', 'group' => 'system'],
            ['name'=> 'admin', 'display_name' => 'Admin', 'group' => 'system'],
            ['name'=> 'employee', 'display_name' => 'Employee', 'group' => 'system'],
            ['name'=> 'manager', 'display_name' => 'Manager', 'group' => 'system'],
            ['name'=> 'user', 'display_name' => 'User', 'group' => 'system']

        ];
        foreach($roles as $role){
            Role::updateOrCreate($role);
        }

        $permissions = [
            ['name'=> 'create-user', 'display_name' => 'Create User', 'group' => 'user'],
            ['name'=> 'update-user', 'display_name' => 'Update User', 'group' => 'user'],
            ['name'=> 'show-user', 'display_name' => 'Show User', 'group' => 'user'],
            ['name'=> 'delete-user', 'display_name' => 'Delete User', 'group' => 'user'],

            ['name'=> 'create-role', 'display_name' => 'Create role', 'group' => 'role'],
            ['name'=> 'update-role', 'display_name' => 'Update role', 'group' => 'role'],
            ['name'=> 'show-role', 'display_name' => 'Show role', 'group' => 'role'],
            ['name'=> 'delete-role', 'display_name' => 'Delete role', 'group' => 'role'],
            
            ['name'=> 'create-product', 'display_name' => 'Create product', 'group' => 'product'],
            ['name'=> 'update-product', 'display_name' => 'Update product', 'group' => 'product'],
            ['name'=> 'show-product', 'display_name' => 'Show product', 'group' => 'product'],
            ['name'=> 'delete-product', 'display_name' => 'Delete product', 'group' => 'product'],

            ['name'=> 'create-category', 'display_name' => 'Create category', 'group' => 'category'],
            ['name'=> 'update-category', 'display_name' => 'Update category', 'group' => 'category'],
            ['name'=> 'show-category', 'display_name' => 'Show category', 'group' => 'category'],
            ['name'=> 'delete-category', 'display_name' => 'Delete category', 'group' => 'category'],
            
        ];
        foreach($permissions as $permission){
            Permission::updateOrCreate($permission);
        }
    }
}
