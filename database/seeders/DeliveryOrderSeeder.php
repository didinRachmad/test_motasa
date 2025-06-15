<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderDetail;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class DeliveryOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil hanya sales orders yang status Final
        $salesOrders = SalesOrder::with('customer')
            ->where('status', 'Final')
            ->take(10)
            ->get();

        $products = Product::all();
        $tanggalCount = [];

        foreach ($salesOrders as $salesOrder) {
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

            // Buat nomor DO
            $tanggal = now()->subDays(rand(0, 20));
            $tanggalKey = $tanggal->format('Ymd');
            $tanggalCount[$tanggalKey] = ($tanggalCount[$tanggalKey] ?? 0) + 1;
            $noDo = 'DO' . $tanggalKey . str_pad($tanggalCount[$tanggalKey], 3, '0', STR_PAD_LEFT);

            // Lokasi tetap
            $origin_name = 'Prajurit Kulon, Mojokerto, Jawa Timur. 61325';
            $destination_name = 'Gempol, Pasuruan, Jawa Timur. 67155';
            $origin = 'IDNP11IDNC285IDND3119IDZ61325';
            $destination = 'IDNP11IDNC340IDND3919IDZ67155';

            // Simpan data header
            $deliveryOrder = DeliveryOrder::create([
                'no_do'            => $noDo,
                'sales_order_id'   => $salesOrder->id,
                'tanggal'          => $tanggal,
                'origin_name'      => $origin_name,
                'destination_name' => $destination_name,
                'origin'           => $origin,
                'destination'      => $destination,
                'status'           => $status,
                'approval_level'   => $approval_level,
                'keterangan'       => $keterangan,
                'total_qty'        => 0,
                'total_diskon'     => 0,
                'grand_total'      => 0,
            ]);

            // Isi detail produk random (bisa diganti pakai detail dari sales_order jika mau)
            $totalQty = 0;
            $totalDiskon = 0;
            $grandTotal = 0;

            $selectedProducts = $products->random(rand(2, 4));

            foreach ($selectedProducts as $product) {
                $qty = rand(5, 20);
                $harga = $product->harga ?? 15000;
                $diskon = $qty > 10 ? $qty * $harga * 0.05 : 0;
                $subtotal = ($harga * $qty) - $diskon;

                DeliveryOrderDetail::create([
                    'delivery_order_id' => $deliveryOrder->id,
                    'product_id'        => $product->id,
                    'qty'               => $qty,
                    'harga'             => $harga,
                    'diskon'            => $diskon,
                    'subtotal'          => $subtotal,
                ]);

                $totalQty += $qty;
                $totalDiskon += $diskon;
                $grandTotal += $subtotal;
            }

            $deliveryOrder->update([
                'total_qty'    => $totalQty,
                'total_diskon' => $totalDiskon,
                'grand_total'  => $grandTotal,
            ]);
        }
    }
}
