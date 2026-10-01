<?php

namespace Database\Seeders;

use App\Models\Penyakit;
use Illuminate\Database\Seeder;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Penyakit::create([
                'id_pasien'  => 1, // Pastikan ID Pasien 1 sampai 10 sudah ada di tabel pasiens
                'bpm'        => rand(60, 100),
                'spo2'       => rand(95, 100),
                'gula_darah' => rand(7000, 18000) / 100, // Menghasilkan nilai decimal acak (contoh: 110.50)
            ]);
        }
    }
}
