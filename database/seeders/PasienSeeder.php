<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $topic = Topic::first(); {
            // 1. Buat User secara otomatis
            // Untuk login: Email = pasien1@gmail.com, Password = password
            $user = User::create([
                'name'     => "admin",
                'email'    => "admin@gmail.com",
                'password' => Hash::make('password'), // Hash password
                'id_topic' => $topic ? $topic->id : 1,
            ]);
            for ($i = 1; $i <= 1; $i++) {
                // 2. Buat Pasien yang terhubung dengan User tersebut
                Pasien::create([
                    'id_user' => $user->id,
                    'name'    => "Pasien " . $i,
                    'age'     => rand(20, 60),
                    'phone'   => "0812345678" . $i,
                    'alamat'  => "Jl. Kesehatan No. " . $i,
                ]);
            }
        }
    }
}
