<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Idempotent: skip jika data sudah ada agar aman dijalankan berkali-kali
        if (Product::count() > 0) {
            return;
        }

        $products = [
            // ── Snack & Minuman ──────────────────────────────────────────────
            [
                'name'        => 'VM Combo S-200',
                'slug'        => 'vm-combo-s-200',
                'category'    => 'snack_minuman',
                'description' => 'Vending machine multifungsi berkapasitas besar untuk snack dan minuman dingin. Layar sentuh 10 inci, sistem pendingin dual-zone, dan mendukung berbagai metode pembayaran termasuk QRIS dan kartu debit. Ideal untuk gedung perkantoran, mall, dan kampus.',
                'price'       => 45000000,
                'specs'       => [
                    'Kapasitas Slot'      => '200 slot (8 lajur × 25 baris)',
                    'Dimensi'             => '180 × 90 × 72 cm',
                    'Berat'               => '150 kg',
                    'Suhu Penyimpanan'    => '4°C – 10°C',
                    'Metode Pembayaran'   => 'QRIS, Kartu Debit, Tunai',
                    'Koneksi'             => 'Wi-Fi, 4G (opsional)',
                    'Daya Listrik'        => '220V / 50Hz / 350W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => true,
            ],
            [
                'name'        => 'VM Combo S-100',
                'slug'        => 'vm-combo-s-100',
                'category'    => 'snack_minuman',
                'description' => 'Vending machine snack dan minuman kapasitas menengah. Cocok untuk kantor kecil, sekolah, atau lokasi dengan traffic sedang. Desain kompak namun tetap bertenaga dengan sistem pendingin andal.',
                'price'       => 32000000,
                'specs'       => [
                    'Kapasitas Slot'      => '100 slot (5 lajur × 20 baris)',
                    'Dimensi'             => '170 × 78 × 68 cm',
                    'Berat'               => '120 kg',
                    'Suhu Penyimpanan'    => '4°C – 10°C',
                    'Metode Pembayaran'   => 'QRIS, Tunai',
                    'Koneksi'             => 'Wi-Fi',
                    'Daya Listrik'        => '220V / 50Hz / 280W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => false,
            ],
            [
                'name'        => 'VM Minuman Dingin MD-150',
                'slug'        => 'vm-minuman-dingin-md-150',
                'category'    => 'snack_minuman',
                'description' => 'Vending machine khusus minuman botol dan kaleng berkapasitas 150 slot. Sistem pendingin berperforma tinggi, ideal untuk area dengan lalu lintas tinggi seperti stasiun, bandara, dan pusat olahraga.',
                'price'       => 38000000,
                'specs'       => [
                    'Kapasitas Slot'      => '150 slot (6 lajur × 25 baris)',
                    'Dimensi'             => '185 × 88 × 70 cm',
                    'Berat'               => '140 kg',
                    'Suhu Penyimpanan'    => '2°C – 8°C',
                    'Metode Pembayaran'   => 'QRIS, Kartu Debit, Tunai',
                    'Koneksi'             => 'Wi-Fi, 4G',
                    'Daya Listrik'        => '220V / 50Hz / 400W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => false,
            ],

            // ── Kopi & Minuman Panas ─────────────────────────────────────────
            [
                'name'        => 'VM Kopi Pro K-100',
                'slug'        => 'vm-kopi-pro-k-100',
                'category'    => 'kopi_panas',
                'description' => 'Mesin kopi otomatis premium dengan 20+ pilihan minuman panas — espresso, cappuccino, latte, teh, cokelat panas, dan lainnya. Sistem grinder biji kopi terintegrasi untuk cita rasa terbaik di setiap sajian.',
                'price'       => 35000000,
                'specs'       => [
                    'Pilihan Menu'        => '20+ jenis minuman',
                    'Kapasitas Air'       => '10 liter',
                    'Kapasitas Biji Kopi' => '1 kg',
                    'Suhu Air'            => '85°C – 95°C (adjustable)',
                    'Dimensi'             => '175 × 70 × 65 cm',
                    'Berat'               => '95 kg',
                    'Metode Pembayaran'   => 'QRIS, Kartu Debit, Tunai',
                    'Daya Listrik'        => '220V / 50Hz / 1.800W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => true,
            ],
            [
                'name'        => 'VM Kopi Lite K-50',
                'slug'        => 'vm-kopi-lite-k-50',
                'category'    => 'kopi_panas',
                'description' => 'Mesin kopi otomatis entry-level dengan 10 pilihan minuman panas. Ukuran kompak dan harga terjangkau, ideal untuk kantor kecil, ruang tunggu, atau co-working space.',
                'price'       => 22000000,
                'specs'       => [
                    'Pilihan Menu'        => '10 jenis minuman',
                    'Kapasitas Air'       => '5 liter',
                    'Kapasitas Biji Kopi' => '500 g',
                    'Suhu Air'            => '85°C – 92°C',
                    'Dimensi'             => '150 × 60 × 55 cm',
                    'Berat'               => '65 kg',
                    'Metode Pembayaran'   => 'QRIS, Tunai',
                    'Daya Listrik'        => '220V / 50Hz / 1.400W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => false,
            ],
            [
                'name'        => 'VM Kopi Premium KP-200',
                'slug'        => 'vm-kopi-premium-kp-200',
                'category'    => 'kopi_panas',
                'description' => 'Vending machine kopi premium flagship dengan kapasitas tertinggi dan 30+ pilihan menu. Layar sentuh 15 inci full-color, sistem IoT terintegrasi, dan opsi koneksi cloud untuk monitoring real-time.',
                'price'       => 55000000,
                'specs'       => [
                    'Pilihan Menu'        => '30+ jenis minuman',
                    'Kapasitas Air'       => '15 liter',
                    'Kapasitas Biji Kopi' => '2 kg (dual hopper)',
                    'Suhu Air'            => '80°C – 98°C (adjustable)',
                    'Dimensi'             => '185 × 75 × 70 cm',
                    'Berat'               => '120 kg',
                    'Metode Pembayaran'   => 'QRIS, Kartu Debit, Tunai, NFC',
                    'Daya Listrik'        => '220V / 50Hz / 2.200W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => false,
            ],

            // ── ATM Beras ────────────────────────────────────────────────────
            [
                'name'        => 'VM ATM Beras R-100',
                'slug'        => 'vm-atm-beras-r-100',
                'category'    => 'atm_beras',
                'description' => 'Vending machine beras kapasitas besar untuk kelurahan, perumahan, atau koperasi. Sistem timbang digital presisi tinggi, harga dapat diatur per kilogram, dan mendukung subsidi harga untuk program sosial pemerintah.',
                'price'       => 28000000,
                'specs'       => [
                    'Kapasitas Beras'     => '100 kg',
                    'Ketelitian Timbang'  => '±10 gram',
                    'Min. Pembelian'      => '0,5 kg',
                    'Dimensi'             => '160 × 80 × 60 cm',
                    'Berat Mesin'         => '80 kg',
                    'Metode Pembayaran'   => 'QRIS, Tunai, Kartu Subsidi',
                    'Daya Listrik'        => '220V / 50Hz / 150W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => true,
            ],
            [
                'name'        => 'VM ATM Beras R-50',
                'slug'        => 'vm-atm-beras-r-50',
                'category'    => 'atm_beras',
                'description' => 'Vending machine beras kapasitas menengah. Cocok untuk RT/RW, warung, atau minimarket. Mudah dioperasikan, perawatan minimal, dan harga unit yang terjangkau dengan ROI cepat.',
                'price'       => 18000000,
                'specs'       => [
                    'Kapasitas Beras'     => '50 kg',
                    'Ketelitian Timbang'  => '±10 gram',
                    'Min. Pembelian'      => '0,5 kg',
                    'Dimensi'             => '140 × 70 × 55 cm',
                    'Berat Mesin'         => '55 kg',
                    'Metode Pembayaran'   => 'QRIS, Tunai',
                    'Daya Listrik'        => '220V / 50Hz / 100W',
                    'Garansi'             => '2 Tahun',
                ],
                'status'      => 'available',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
