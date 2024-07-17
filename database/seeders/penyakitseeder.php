<?php

namespace Database\Seeders;

use App\Models\penyakit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class penyakitseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menggunakan query builder untuk memasukkan data dummy
        DB::table('penyakits')->insert([
            [
                'id_pasien' => 5, // Pastikan pasien dengan ID ini ada
                'bpm' => 72,
                'spo2' => 98,
                'gula_darah' => 90,
            ],
            [
                'id_pasien' => 3, // Pastikan pasien dengan ID ini ada
                'bpm' => 80,
                'spo2' => 99,
                'gula_darah' => 100,
            ],
            // Tambahkan data lain sesuai kebutuhan
        ]);

        // Alternatif dengan menggunakan Eloquent Model
        penyakit::factory()->count(10)->create();
    }
}
