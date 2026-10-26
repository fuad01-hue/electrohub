<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'PT Sumber Rejeki Pangan', 'phone' => '0651-555-0101', 'email' => 'order@sumberrejeki.example'],
            ['name' => 'CV Aceh Jaya Distribusi',  'phone' => '0651-555-0102', 'email' => 'sales@acehjaya.example'],
            ['name' => 'UD Mitra Kertas Nusantara', 'phone' => '0651-555-0103', 'email' => 'info@mitrakertas.example'],
            ['name' => 'PT Bersih Sejahtera',       'phone' => '0651-555-0104', 'email' => 'cs@bersihsejahtera.example'],
        ];

        foreach ($suppliers as $s) {
            Supplier::firstOrCreate(['name' => $s['name']], $s);
        }
    }
}
