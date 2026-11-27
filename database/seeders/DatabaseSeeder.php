<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin & Mahasiswa
        User::updateOrCreate(
            ['email' => 'admin@MMC.ac.id'],
            [
                'name' => 'Admin Laboran MMC',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nim_nip' => '198501012015041001',
                'no_hp' => '081234567890',
                'prodi' => 'Teknologi Informasi',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mahasiswa@MMC.ac.id'],
            [
                'name' => 'Ahmad Fajar',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'nim_nip' => 'E41220001',
                'no_hp' => '085712345678',
                'prodi' => 'Teknik Informatika',
            ]
        );

        // 2. Buat Kategori
        $katMusik = Category::updateOrCreate(
            ['slug' => 'alat-musik'],
            [
                'nama' => 'Alat Musik',
                'icon' => 'bi-music-note-beamed',
                'deskripsi' => 'Peralatan instrumen dan audio untuk studio musik/event MMC.',
            ]
        );

        $katSyuting = Category::updateOrCreate(
            ['slug' => 'alat-syuting'],
            [
                'nama' => 'Alat Syuting',
                'icon' => 'bi-camera-video-fill',
                'deskripsi' => 'Peralatan kamera, pencahayaan, dan audio untuk produksi multimedia & video.',
            ]
        );

        $katPc = Category::updateOrCreate(
            ['slug' => 'pc'],
            [
                'nama' => 'PC / Komputer & Periferal',
                'icon' => 'bi-pc-display',
                'deskripsi' => 'Perangkat komputer, laptop, monitor, dan periferal lab MMC.',
            ]
        );

        // 3. Buat Barang-Barang
        $items = [
            // Alat Musik
            [
                'category_id' => $katMusik->id,
                'kode_barang' => 'MSK-001',
                'nama_barang' => 'Gitar Akustik Elektrik',
                'merk' => 'Yamaha FX310',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Studio Musik Gedung TI Lt. 2',
                'deskripsi' => 'Gitar akustik dengan pickup preamp bawaan.',
            ],
            [
                'category_id' => $katMusik->id,
                'kode_barang' => 'MSK-002',
                'nama_barang' => 'Keyboard Synthesizer 61-Keys',
                'merk' => 'Roland XPS-30',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Studio Musik Gedung TI Lt. 2',
                'deskripsi' => 'Keyboard lengkap dengan adaptor dan sustain pedal.',
            ],
            [
                'category_id' => $katMusik->id,
                'kode_barang' => 'MSK-003',
                'nama_barang' => 'Microphone Dynamic Vokal',
                'merk' => 'Shure SM58',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Lemari Audio Lab Multimedia',
                'deskripsi' => 'Mic kabel standar vokal panggung/rekaman.',
            ],
            [
                'category_id' => $katMusik->id,
                'kode_barang' => 'MSK-004',
                'nama_barang' => 'USB Audio Interface 2-Channel',
                'merk' => 'Focusrite Scarlett 2i2 Gen 3',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Lab Multimedia',
                'deskripsi' => 'Soundcard USB type C untuk rekaman instrumen & mic XLR.',
            ],

            // Alat Syuting
            [
                'category_id' => $katSyuting->id,
                'kode_barang' => 'SYT-001',
                'nama_barang' => 'Kamera Mirrorless 4K',
                'merk' => 'Sony Alpha a6400 (Kit 16-50mm)',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Dry Cabinet Lab Multimedia',
                'deskripsi' => 'Dilengkapi 2 baterai, charger, dan memory card 64GB.',
            ],
            [
                'category_id' => $katSyuting->id,
                'kode_barang' => 'SYT-002',
                'nama_barang' => 'Tripod Video Profesional',
                'merk' => 'Libec TH-X',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Ruang Penyimpanan Alat Multimedia',
                'deskripsi' => 'Tripod heavy duty dengan fluid head halus untuk pan & tilt.',
            ],
            [
                'category_id' => $katSyuting->id,
                'kode_barang' => 'SYT-003',
                'nama_barang' => 'Lighting Studio LED Softbox',
                'merk' => 'Godox SL60W 5600K',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Studio Foto MMC',
                'deskripsi' => 'Lampu continuous daylight lengkap dengan stand dan softbox 60x90cm.',
            ],
            [
                'category_id' => $katSyuting->id,
                'kode_barang' => 'SYT-004',
                'nama_barang' => 'Gimbal Stabilizer 3-Axis',
                'merk' => 'DJI Ronin-SC',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Dry Cabinet Lab Multimedia',
                'deskripsi' => 'Stabilizer kamera mirrorless dengan tas jinjing dan kabel kontrol.',
            ],
            [
                'category_id' => $katSyuting->id,
                'kode_barang' => 'SYT-005',
                'nama_barang' => 'Wireless Clip-On Microphone (2 TX + 1 RX)',
                'merk' => 'Boya BY-XM6-S2',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Lemari Audio Lab Multimedia',
                'deskripsi' => 'Mic wireless lavalier 2 transmitter untuk wawancara.',
            ],

            // PC & Periferal
            [
                'category_id' => $katPc->id,
                'kode_barang' => 'PC-001',
                'nama_barang' => 'Laptop Core i7 Gen 13',
                'merk' => 'Acer Swift Go 14 OLED',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Lab Rekayasa Perangkat Lunak',
                'deskripsi' => 'Laptop i7-13700H, RAM 16GB, SSD 1TB untuk render/coding mobile.',
            ],
            [
                'category_id' => $katPc->id,
                'kode_barang' => 'PC-002',
                'nama_barang' => 'Pen Display Drawing Tablet',
                'merk' => 'Wacom Intuos Pro Medium PTH-660',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Lab Desain Komunikasi Visual',
                'deskripsi' => 'Drawing pad grafis presisi tinggi untuk animasi & desain grafis.',
            ],
            [
                'category_id' => $katPc->id,
                'kode_barang' => 'PC-003',
                'nama_barang' => 'Monitor Gaming/Editing 24 Inch 144Hz',
                'merk' => 'LG UltraGear 24GN600-B IPS',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Lab Multimedia',
                'deskripsi' => 'Monitor IPS akurasi warna sRGB 99% + kabel HDMI & DP.',
            ],
            [
                'category_id' => $katPc->id,
                'kode_barang' => 'PC-004',
                'nama_barang' => 'Unit PC Workstation Tower',
                'merk' => 'Custom Ryzen 7 5700X / RTX 3060 12GB',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'lokasi_penyimpanan' => 'Lab Multimedia Gedung TI',
                'deskripsi' => 'Workstation untuk rendering 3D, Blender, dan AI modeling.',
            ],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(['kode_barang' => $item['kode_barang']], $item);
        }
    }
}
