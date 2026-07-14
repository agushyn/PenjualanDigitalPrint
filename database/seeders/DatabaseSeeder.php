<?php

// database/seeders/DutaPrintSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN UTAMA (ADMIN, KASIR, DESIGN)
        User::create([
            'name' => 'Budi Setiawan',
            'email' => 'admin@dutaprint.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'theme_color' => '#ff3366', // Pink Aksen
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'kasir@dutaprint.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
            'theme_color' => '#ffec00', // Yellow Aksen
        ]);

        User::create([
            'name' => 'Rian Hidayat',
            'email' => 'design@dutaprint.com',
            'password' => Hash::make('password123'),
            'role' => 'design',
            'theme_color' => '#00f5ff', // Cyan Aksen
        ]);

        // 2. BUAT 7 AKUN OPERATOR MESIN BERBEDA
        $machines = ['outdoor', 'indoor', 'ricoh', 'riso', 'cardpresso', 'sablon', 'cutting'];
        foreach ($machines as $machine) {
            User::create([
                'name' => 'Operator ' . ucfirst($machine),
                'email' => "operator.{$machine}@dutaprint.com",
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'operator_machine' => $machine,
                'theme_color' => '#adff2f', // Hijau Neon
            ]);
        }

        // 3. BUAT DATA DUMMY PENJUALAN & ANTREAN PRODUKSI
        $sale1 = Sale::create([
            'invoice_number' => 'DP-17180001',
            'customer_name' => 'CV Makmur Sejahtera',
            'total_price' => 450000.00,
            'user_id' => 2, // Kasir
        ]);

        SaleItem::create([
            'sale_id' => $sale1->id,
            'item_name' => 'Baliho Promosi Toko 4x3 Meter',
            'machine' => 'outdoor',
            'qty' => 1,
            'price' => 360000.00,
            'subtotal' => 360000.00,
            'status' => 'proses',
            'notes' => 'Mata ayam keliling setiap 1 meter, bahan tebal 340gr.',
        ]);

        SaleItem::create([
            'sale_id' => $sale1->id,
            'item_name' => 'Finishing Cutting Pola Baliho',
            'machine' => 'cutting',
            'qty' => 1,
            'price' => 90000.00,
            'subtotal' => 90000.00,
            'status' => 'pending',
            'notes' => 'Potong pas di garis tepi hitam gambar.',
        ]);

        $sale2 = Sale::create([
            'invoice_number' => 'DP-17180002',
            'customer_name' => 'Bpk. Hendra Gunawan',
            'total_price' => 250000.00,
            'user_id' => 2, // Kasir
        ]);

        SaleItem::create([
            'sale_id' => $sale2->id,
            'item_name' => 'Cetak Stiker Vinyl Ritrama A3+',
            'machine' => 'ricoh',
            'qty' => 10,
            'price' => 25000.00,
            'subtotal' => 250000.00,
            'status' => 'pending',
            'notes' => 'Laminasi Matte/Doff dingin.',
        ]);
    }
}
