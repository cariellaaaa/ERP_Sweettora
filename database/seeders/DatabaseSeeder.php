<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            PermissionsSeeder::class
        ]);

        $admin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@email.com',
            'password' => Hash::make('123456')
        ]);

        $role = Role::where('name', 'admin')->value('id');
        $admin->assignRole($role);

        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@email.com',
            'password' => Hash::make('123456')
        ]);

        $managerRole = Role::where('name', 'manager')->value('id');
        $manager->assignRole($managerRole);

        $staff = User::create([
            'name' => 'Staff',
            'email' => 'staff@email.com',
            'password' => Hash::make('123456')
        ]);

        $staffRole = Role::where('name', 'staff')->value('id');
        $staff->assignRole($staffRole);
    }
}
