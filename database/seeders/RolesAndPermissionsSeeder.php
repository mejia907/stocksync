<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions 
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',

            'view inventory_movements',
            'create inventory_entries',
            'create inventory_exits',

            'view orders',
            'create orders',

            'view warehouses',
            'create warehouses',
            'edit warehouses',
            'delete warehouses',

            'view clients',
            'create clients',
            'edit clients',
            'delete clients',

            'view suppliers',
            'create suppliers',
            'edit suppliers',
            'delete suppliers',

            'view users',
            'create users',
            'edit users',
            'delete users',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            'assign roles',
            'view permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $warehouseOperatorRole = Role::create(['name' => 'warehouse_operator']);
        $assistantRole = Role::create(['name' => 'assistant']);

         // Assign permissions to roles 
         $adminRole->givePermissionTo(Permission::all());
         $warehouseOperatorRole->givePermissionTo([
            'view products', 'create products', 'edit products', 'delete products',
            'view inventory_movements', 'create inventory_entries', 'create inventory_exits',
            'view orders', 'create orders',
            'view warehouses', 'create warehouses', 'edit warehouses', 'delete warehouses',
            'view clients', 'create clients', 'edit clients', 'delete clients',
            'view suppliers', 'create suppliers', 'edit suppliers', 'delete suppliers',
         ]);
         $assistantRole->givePermissionTo([
            'view products',
            'view inventory_movements',
            'view warehouses',
            'view suppliers',
        ]);

        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
