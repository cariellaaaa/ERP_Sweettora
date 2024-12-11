<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'products',
            'units',
            'product-categories',
            'vendors',
            'users',
            'countries',
            'bill-of-materials',
            'manufacturing-orders',
            'companies',
            'purchase-orders',
            'receive-items',
            'bills',
            'sales-orders',
            'delivery-orders',
            'sales-invoices'
        ];

        $actions = ['create', 'read', 'update', 'delete'];
        $specialActions = ['approve', 'cancel'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}_{$module}"]);
            }

            // Add special actions
            if (in_array($module, ['purchase-orders', 'receive-items', 'transfer-stocks', 'sales-orders', 'delivery-orders', 'sales-invoices', 'stock-adjustments'])) {
                foreach ($specialActions as $special) {
                    Permission::firstOrCreate(['name' => "{$special}_{$module}"]);
                }
            }
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerPermissions = Permission::whereIn('name', [
            'read_products',
            'read_purchase-orders',
            'approve_purchase-orders'
        ])->get();
        $managerRole->syncPermissions($managerPermissions);

        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffPermissions = Permission::whereIn('name', [
            'create_products',
            'read_products',
            'update_products'
        ])->get();
        $staffRole->syncPermissions($staffPermissions);
    }
}
