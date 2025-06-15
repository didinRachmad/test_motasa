<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $adminDepo  = Role::firstOrCreate(['name' => 'Admin Depo', 'guard_name' => 'web']);
        $spvDepo    = Role::firstOrCreate(['name' => 'SPV Depo', 'guard_name' => 'web']);

        $menus = Menu::all();
        $permissions = Permission::all();

        foreach ($menus as $menu) {
            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insertOrIgnore([
                    'role_id'       => $superAdmin->id,
                    'permission_id' => $permission->id,
                    'menu_id'       => $menu->id,
                ]);
            }
        }

        $adminDepoMenus = [
            'master_products',
            'master_customers',
            'transaksi_sales_orders',
            'transaksi_delivery_orders',
            'profile'
        ];

        foreach ($adminDepoMenus as $menuName) {
            $menu = Menu::where('route', $menuName)->first();
            if (!$menu) continue;

            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insertOrIgnore([
                    'role_id'       => $adminDepo->id,
                    'permission_id' => $permission->id,
                    'menu_id'       => $menu->id,
                ]);
            }
        }

        $spvMenus = [
            'transaksi_sales_orders',
            'transaksi_delivery_orders',
            'profile'
        ];

        $allowedSpvPermissions = ['index', 'show', 'approve', 'print'];

        foreach ($spvMenus as $menuName) {
            $menu = Menu::where('route', $menuName)->first();
            if (!$menu) continue;

            foreach ($permissions as $permission) {
                if (in_array($permission->name, $allowedSpvPermissions)) {
                    DB::table('role_has_permissions')->insertOrIgnore([
                        'role_id'       => $spvDepo->id,
                        'permission_id' => $permission->id,
                        'menu_id'       => $menu->id,
                    ]);
                }
            }
        }
    }
}
