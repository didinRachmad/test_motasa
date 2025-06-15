<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'index',
            'show',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'approve',
            'print',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdminRole = Role::create(['name' => 'super_admin']);
        $adminDepoRole = Role::create(['name' => 'Admin Depo']);
        $SPVDepoRole = Role::create(['name' => 'SPV Depo']);

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        $user1 = User::factory()->create([
            'name' => 'Admin Depo',
            'email' => 'admin@depo.com',
            'password' => Hash::make('12345678'),
        ]);
        $user1->assignRole($adminDepoRole);

        $user2 = User::factory()->create([
            'name' => 'SPV Depo',
            'email' => 'spv@depo.com',
            'password' => Hash::make('12345678'),
        ]);
        $user2->assignRole($SPVDepoRole);
    }
}
