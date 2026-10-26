<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laptop   = Category::where('name', 'Laptop & Gaming Notebook')->first();
        $monitor  = Category::where('name', 'Monitor & Display')->first();
        $komponen = Category::where('name', 'Komponen PC & Hardware')->first();
        $aksesoris = Category::where('name', 'Aksesoris & Peripheral')->first();

        $products = [
            [
                'category_id'    => $laptop->id ?? 1,
                'sku'            => 'LPT-ASUS-ROG01',
                'name'           => 'ASUS ROG Strix G16 (2025)',
                'brand'          => 'ASUS',
                'specifications' => 'Intel Core i7-13650HX, RAM 16GB DDR5, SSD 1TB NVMe, RTX 4060 8GB, 16" FHD+ 165Hz',
                'purchase_price' => 21500000,
                'selling_price'  => 23999000,
                'stock'          => 8,
                'minimum_stock'  => 3,
            ],
            [
                'category_id'    => $laptop->id ?? 1,
                'sku'            => 'LPT-LEN-LOQ15',
                'name'           => 'Lenovo LOQ 15 IRH8 Gaming',
                'brand'          => 'Lenovo',
                'specifications' => 'Intel Core i5-13420H, RAM 16GB DDR5, SSD 512GB, RTX 3050 6GB, 15.6" FHD 144Hz',
                'purchase_price' => 11800000,
                'selling_price'  => 13499000,
                'stock'          => 2,
                'minimum_stock'  => 5,
            ],
            [
                'category_id'    => $monitor->id ?? 1,
                'sku'            => 'MON-LG-27GP850',
                'name'           => 'LG UltraGear 27" Nano IPS Gaming Monitor',
                'brand'          => 'LG',
                'specifications' => '27 Inch QHD (2560x1440), Nano IPS, 180Hz, 1ms, HDR400, G-Sync Compatible',
                'purchase_price' => 4200000,
                'selling_price'  => 4850000,
                'stock'          => 12,
                'minimum_stock'  => 4,
            ],
            [
                'category_id'    => $komponen->id ?? 1,
                'sku'            => 'SSD-SAM-990PRO',
                'name'           => 'Samsung 990 PRO NVMe M.2 SSD 1TB',
                'brand'          => 'Samsung',
                'specifications' => '1TB PCIe 4.0 NVMe M.2, Read Speed up to 7450 MB/s, Write 6900 MB/s',
                'purchase_price' => 1650000,
                'selling_price'  => 1950000,
                'stock'          => 25,
                'minimum_stock'  => 5,
            ],
            [
                'category_id'    => $aksesoris->id ?? 1,
                'sku'            => 'ACC-LOG-GPX2',
                'name'           => 'Logitech G PRO X Superlight 2 Wireless',
                'brand'          => 'Logitech',
                'specifications' => 'HERO 2 Sensor 32K DPI, Lightforce Hybrid Switches, 60g Ultra Lightweight, USB-C',
                'purchase_price' => 1900000,
                'selling_price'  => 2290000,
                'stock'          => 3,
                'minimum_stock'  => 5,
            ],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(['sku' => $item['sku']], $item);
        }
    }
}