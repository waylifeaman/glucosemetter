<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Topic::create([
                'instansi'  => "Instansi Kesehatan " . $i,
                'topic_pub' => "sensor/pub/device-" . $i,
                'topic_sub' => "sensor/sub/device-" . $i,
            ]);
        }
    }
}
