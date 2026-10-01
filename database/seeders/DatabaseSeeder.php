<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Pastikan PasienSeeder dipanggil lebih dulu agar foreign key id_pasien tidak error

            TopicSeeder::class,
            PasienSeeder::class,
            PenyakitSeeder::class,
        ]);
    }
}
