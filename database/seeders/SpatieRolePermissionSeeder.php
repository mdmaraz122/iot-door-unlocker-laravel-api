<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SpatieRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions (based on your middleware names)
        $permissions = [
            'user-list', 'user-create', 'user-update', 'user-delete',
            'role-list', 'role-create', 'role-update', 'role-delete',
            'permission-list', 'permission-create', 'permission-update', 'permission-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        // Create a super admin role and assign all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole->syncPermissions(Permission::all());

        // Assign role to first user
        $user = User::first();
        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
