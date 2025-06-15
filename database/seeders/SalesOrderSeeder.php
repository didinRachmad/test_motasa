<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class SalesOrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::inRandomOrder()->take(20)->get();
        $products = Product::all();

        $pembayaranList = ['Tunai', 'Transfer'];
        $diskonRate = 0.05;

        $tanggalCount = [];

        foreach ($customers as $index => $customer) {
            $approval_level = rand(0, 3);

            if ($approval_level === 0) {
                $status = 'Draft';
                $keterangan = '';
            } elseif ($approval_level === 1) {
                $status = fake()->randomElement(['Rejected', 'Revised']);
                $keterangan = $status === 'Rejected'
                    ? 'Pesanan ditolak karena tidak sesuai'
                    : 'Perlu revisi pada detail pesanan';
            } elseif ($approval_level === 2) {
                $status = 'Waiting Approval';
                $keterangan = 'Menunggu persetujuan dari level berikutnya';
            } else {
                $status = 'Final';
                $keterangan = 'Pesanan telah disetujui dan final';
            }

            $tanggal = now()->subDays(rand(0, 30));

            $tanggalKey = $tanggal->format('Ymd');
            if (!isset($tanggalCount[$tanggalKey])) {
                $tanggalCount[$tanggalKey] = 1;
            } else {
                $tanggalCount[$tanggalKey]++;
            }

            $noSo = 'SO' . $tanggalKey . str_pad($tanggalCount[$tanggalKey], 3, '0', STR_PAD_LEFT);

            $salesOrder = SalesOrder::create([
                'no_so'             => $noSo,
                'customer_id'       => $customer->id,
                'metode_pembayaran' => $pembayaranList[array_rand($pembayaranList)],
                'tanggal'           => $tanggal,
                'total_qty'         => 0,
                'total_diskon'      => 0,
                'grand_total'       => 0,
                'approval_level'    => $approval_level,
                'status'            => $status,
                'keterangan'        => $keterangan,
            ]);

            $totalQty = 0;
            $totalDiskon = 0;
            $grandTotal = 0;

            $selectedProducts = $products->random(rand(2, 4));

            foreach ($selectedProducts as $product) {
                $qty = rand(5, 30);
                $harga = $product->harga ?? 15000;
                $diskon = $qty > 20 ? $qty * $harga * $diskonRate : 0;
                $subtotal = ($harga * $qty) - $diskon;

                SalesOrderDetail::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id'     => $product->id,
                    'qty'            => $qty,
                    'harga'          => $harga,
                    'diskon'         => $diskon,
                    'subtotal'       => $subtotal,
                ]);

                $totalQty += $qty;
                $totalDiskon += $diskon;
                $grandTotal += $subtotal;
            }

            $salesOrder->update([
                'total_qty'    => $totalQty,
                'total_diskon' => $totalDiskon,
                'grand_total'  => $grandTotal,
            ]);
        }
    }
}
