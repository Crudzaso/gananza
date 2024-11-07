<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar el modelo User
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

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
            'organizer' => ['view_rifas', 'create_rifas', 'edit_rifas', 'delete_rifas'],
            'admin' => ['manage_users', 'view_rifas', 'create_rifas', 'edit_rifas', 'delete_rifas']
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }

        // Crear un usuario administrador
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'], // Cambia este email si es necesario
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'), // Cambia esta contraseña si es necesario
            ]
        );

        // Asignar el rol de admin al usuario creado
        $adminUser->assignRole('admin');
    }
}
