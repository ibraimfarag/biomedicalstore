<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles or fetch existing ones
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $manager = Role::firstOrCreate(['name' => 'manager']);

        // Create permissions or fetch existing ones
        $permissions = [
            'view_dashboard',
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'manage_inventory',
            'place_orders',
            'view_reports'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->permissions()->sync(Permission::all()->pluck('id')->toArray()); // Admin gets all permissions
        $manager->permissions()->sync(Permission::whereIn('name', ['view_dashboard', 'manage_inventory', 'view_reports'])->pluck('id')->toArray());
        $user->permissions()->sync(Permission::whereIn('name', ['view_dashboard', 'place_orders'])->pluck('id')->toArray());
    }

}
