<?php

namespace App\Console\Commands;

use App\Models\penyakit;
use App\Services\MQTTService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SubscribeToMQTT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to MQTT topic and save data to the database';
    protected $mqttService;
    public function __construct(MQTTService $mqttService)
    {
        parent::__construct();
        $this->mqttService = $mqttService;
    }
    public function handle()
    {
        Log::info('Starting MQTT subscription...');

        try {
            $this->mqttService->subscribe('postdataGluc', function ($topic, $message) {
                Log::info("Received message: $message");
                // Decode JSON message
                $data = json_decode($message, true);

                if ($data && isset($data['id'], $data['BPM'], $data['SpO2'], $data['PredictedGlucose'])) {
                    // Insert data into the 'penyakits' table
                    penyakit::create([
                        'id_pasien' => $data['id'],
                        'bpm' => $data['BPM'],
                        'spo2' => $data['SpO2'],
                        'gula_darah' => $data['PredictedGlucose']
                    ]);
                    Log::info("Data inserted successfully: $message");
                } else {
                    // Handle invalid data
                    Log::error('Invalid data received from MQTT topic.');
                }
            });
        } catch (\Exception $e) {
            Log::error('An error occurred while subscribing to MQTT: ' . $e->getMessage());
        }
    }
}
