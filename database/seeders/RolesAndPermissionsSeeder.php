<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            ['name' => 'users.view', 'display_name' => 'View Users', 'group' => 'users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'group' => 'users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'group' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'group' => 'users'],
            ['name' => 'users.activate', 'display_name' => 'Activate/Deactivate Users', 'group' => 'users'],
            ['name' => 'users.reset-password', 'display_name' => 'Reset User Passwords', 'group' => 'users'],
            
            // Role management
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'group' => 'roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'group' => 'roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'group' => 'roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'group' => 'roles'],
            ['name' => 'roles.assign', 'display_name' => 'Assign Roles', 'group' => 'roles'],
            
            // System management
            ['name' => 'system.settings', 'display_name' => 'System Settings', 'group' => 'system'],
            ['name' => 'system.logs', 'display_name' => 'View System Logs', 'group' => 'system'],
            ['name' => 'system.backup', 'display_name' => 'System Backup', 'group' => 'system'],
            
            // API management
            ['name' => 'api.access', 'display_name' => 'API Access', 'group' => 'api'],
            ['name' => 'api.admin', 'display_name' => 'Admin API Access', 'group' => 'api'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Create roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full system access with all permissions',
                'permissions' => Permission::pluck('name')->toArray(),
            ],
            [
                'name' => 'moderator',
                'display_name' => 'Moderator',
                'description' => 'Can manage users and view system information',
                'permissions' => [
                    'users.view', 'users.edit', 'users.activate', 'users.reset-password',
                    'roles.view', 'system.logs', 'api.access',
                ],
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Standard user with basic access',
                'permissions' => [
                    'api.access',
                ],
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
