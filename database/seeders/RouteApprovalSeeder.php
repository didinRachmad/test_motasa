<?php

namespace Database\Seeders;

use App\Models\Role;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role yang dibutuhkan
        $superAdmin = Role::where('name', 'super_admin')->first();
        $adminDepo = Role::where('name', 'Admin Depo')->first();
        $spvDepo   = Role::where('name', 'SPV Depo')->first();

        if (!$adminDepo || !$spvDepo) {
            throw new \Exception("Role 'admin_depo' atau 'spv_depo' tidak ditemukan.");
        }

        // Daftar module yang butuh approval route
        $modules = ['transaksi_sales_orders', 'transaksi_delivery_orders'];

        foreach ($modules as $module) {
            // Sequence 1 – Admin Depo
            DB::table('approval_routes')->insertOrIgnore([
                'module'            => $module,
                'role_id'           => $adminDepo->id,
                'sequence'          => 1,
                'assigned_user_id'  => null, // default kosong
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // Sequence 2 – SPV Depo
            DB::table('approval_routes')->insertOrIgnore([
                'module'            => $module,
                'role_id'           => $spvDepo->id,
                'sequence'          => 2,
                'assigned_user_id'  => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // Sequence 1 – Super Admin
            DB::table('approval_routes')->insertOrIgnore([
                'module'            => $module,
                'role_id'           => $superAdmin->id,
                'sequence'          => 1,
                'assigned_user_id'  => null, // default kosong
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // Sequence 2 – Super Admin
            DB::table('approval_routes')->insertOrIgnore([
                'module'            => $module,
                'role_id'           => $superAdmin->id,
                'sequence'          => 2,
                'assigned_user_id'  => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
