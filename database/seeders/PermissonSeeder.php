<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class PermissonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-users', 'guard_name' => 'api']);
        Permission::create(['name' => 'list-users', 'guard_name' => 'api']);

        Permission::create(['name' => 'create-products', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit-products', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete-products', 'guard_name' => 'api']);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);

        $adminRole->givePermissionTo([
            'create-users',
            'list-users',
            'create-products',
            'edit-products',
            'delete-products',
        ]);

        $userRole->givePermissionTo([
            'create-products',
            'edit-products',
            'delete-products',
        ]);

    }
}
