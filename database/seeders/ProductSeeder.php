<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_produk' => 'LDK33', 'nama_produk' => 'LADAKU', 'harga' => 1000],
            ['kode_produk' => 'DKU02', 'nama_produk' => 'KUNYIT', 'harga' => 1000],
            ['kode_produk' => 'DSK07', 'nama_produk' => 'KETUMBAR', 'harga' => 1000],
            ['kode_produk' => 'DMR01', 'nama_produk' => 'MARINASI', 'harga' => 1000],
            ['kode_produk' => 'DBL01', 'nama_produk' => 'BALADO', 'harga' => 1000],
            ['kode_produk' => 'DSO01', 'nama_produk' => 'OPOR', 'harga' => 1000],
            ['kode_produk' => 'DLD02', 'nama_produk' => 'LODEH', 'harga' => 1000],
            ['kode_produk' => 'DKR01', 'nama_produk' => 'KARI', 'harga' => 1000],
            ['kode_produk' => 'DSG02', 'nama_produk' => 'SAMBAL GORENG', 'harga' => 1000],
            ['kode_produk' => 'DGL01', 'nama_produk' => 'GULAI', 'harga' => 1000],
            ['kode_produk' => 'DCB02', 'nama_produk' => 'CABE', 'harga' => 1000],
            ['kode_produk' => 'DBP05', 'nama_produk' => 'BAWANG PUTIH', 'harga' => 1000],
        ];

        foreach ($data as &$item) {
            $item['kemasan'] = 'pack';
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('products')->insert($data);
    }
}
