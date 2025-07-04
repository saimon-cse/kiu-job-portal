<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Create Permissions
        $permissions = [
            // User Permissions
            'submit-applications',
            'view-own-applications',
            'edit-own-profile',

            // Admin Permissions
            'manage-jobs',          // A catch-all for job-related tasks
            'view-all-applications',
            'update-application-status',
            'manage-users',         // For general user management (not other admins)

            // Super Admin Permissions
            'manage-settings',
            'manage-roles',         // Ability to manage roles and permissions themselves
            'view-system-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. Create Roles and Assign Existing Permissions

        // Role: User (Applicant)
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo([
            'submit-applications',
            'view-own-applications',
            'edit-own-profile',
        ]);

        // Role: Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage-jobs',
            'view-all-applications',
            'update-application-status',
            'manage-users',
        ]);

        // Role: Super Admin
        // Gets all permissions via a gate. No need to assign them directly.
        // Or, for explicit permissions:
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // 4. Create Demo Users and Assign Roles

        // Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@kiu.ac.bd'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Use a secure password in production!
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@kiu.ac.bd'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        // Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@kiu.ac.bd'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole($userRole);
    }
}
