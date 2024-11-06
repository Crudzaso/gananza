<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Crear permisos
        $permissions = ['view_rifas', 'create_rifas', 'edit_rifas', 'delete_rifas', 'manage_users'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $roles = [
            'userPublic' => [],
            'client' => ['view_rifas'],
            'organizador' => ['view_rifas', 'create_rifas', 'edit_rifas', 'delete_rifas'],
            'admin' => ['manage_users', 'view_rifas', 'create_rifas', 'edit_rifas', 'delete_rifas']
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }
    }
}
