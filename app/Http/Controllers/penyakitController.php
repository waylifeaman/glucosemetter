<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\penyakit;
use App\Models\espSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use App\Services\MQTTService;

class penyakitController extends Controller

{
    protected $mqttService;

    public function __construct(MQTTService $mqttService)
    {
        $this->mqttService = $mqttService;
    }

    public function index(Request $request)
    {
        $penyakit = penyakit::all();
        return view('penyakit_detail', compact('penyakit'));
    }

    public function store(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'id_pasien' => 'required|numeric',
                'bpm' => 'required|numeric',
                'spo2' => 'required|numeric',
                'gula_darah' => 'required|numeric',
                'time' => 'required|date_format:Y-m-d H:i:s', // Ensure time is in correct format
            ]);

            // Create a new record using Eloquent
            $penyakit = penyakit::create([
                'id_pasien' => $validatedData['id_pasien'],
                'bpm' => $validatedData['bpm'],
                'spo2' => $validatedData['spo2'],
                'gula_darah' => $validatedData['gula_darah'],
                'time' => $validatedData['time'],
                'updated_at' => now(),
                'created_at' => now(),
            ]);

            // Return success message with JSON response
            return response()->json([
                'message' => 'Successfully inserted data.',
                'data' => $penyakit
            ], 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error storing data: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Failed to store data.'], 500);
        }
    }


    public function show($id_pasien)
    {
        // Dapatkan data penyakit terbaru berdasarkan id_pasien
        $penyakit = penyakit::where(
            'id_pasien',
            $id_pasien
        )->orderBy('created_at', 'desc')->first();
        $pasien = Pasien::find($id_pasien);
        $penyakits = penyakit::where('id_pasien', $id_pasien)->orderBy('created_at', 'desc')->take(10)->get();
        // Simpan id_pasien dalam sesi
        session(['id_pasien' => $id_pasien]);


        $chartpenyakits = penyakit::where('id_pasien', $id_pasien)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get(['gula_darah', 'created_at']);

        // Format data menjadi array yang dapat digunakan di JavaScript
        $gula_darah = [];
        // $kolesterol = [];
        $labels = [];

        foreach ($chartpenyakits as $penyakit) {
            $gula_darah[] = $penyakit->gula_darah;
            $labels[] = $penyakit->created_at->format('l'); // Menggunakan format 'l' untuk nama hari penuh

        }

        // Konversi data ke format JSON untuk JavaScript
        $gula_darah_json = json_encode(array_reverse($gula_darah));
        $labels_json = json_encode(array_reverse($labels));

        // Tampilkan view dengan data yang didapat
        return view('penyakit_detail', compact('penyakit', 'pasien', 'penyakits', 'gula_darah_json', 'labels_json'));
    }

    public function updateChart($id_pasien)
    {
        $chartpenyakits = penyakit::where('id_pasien', $id_pasien)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get(['gula_darah', 'created_at']);

        $gula_darah = [];
        // $kolesterol = [];
        $labels = [];

        foreach ($chartpenyakits as $penyakit) {
            $gula_darah[] = $penyakit->gula_darah;
            $labels[] = $penyakit->created_at->format('l');
        }

        return response()->json([
            'gula_darah' => array_reverse($gula_darah),
            'labels' => array_reverse($labels),
        ]);
    }



    public function getRealtimeData($id_pasien)
    {
        // Dapatkan data penyakit terbaru berdasarkan id_pasien
        $penyakit = penyakit::where('id_pasien', $id_pasien)->orderBy('created_at', 'desc')->first();
        return response()->json($penyakit);
    }

    public function getRealtimeTableData($id_pasien)
    {
        // Dapatkan 20 data penyakit terbaru berdasarkan id_pasien
        $penyakits = penyakit::where('id_pasien', $id_pasien)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($penyakit) {
                $penyakit->created_at_formatted = \Carbon\Carbon::parse($penyakit->created_at)->format('d-m-Y H:i:s');
                return $penyakit;
            });
        return response()->json($penyakits);
    }

    public function sendData(Request $request)
    {
        try {
            // Validasi data request, tambahkan validasi untuk 'name'
            $validatedData = $request->validate([
                'value' => 'required|numeric',
                'name' => 'required|string|max:255' // Validasi untuk 'name'
            ]);

            // Cast nilai value ke integer
            $value = (int) $validatedData['value'];
            $name = $validatedData['name']; // Ambil nilai 'name'

            // Pastikan nilai 'id' dan 'nama' sudah benar
            $data = [
                'id' => $value,
                'nama' => $name
            ];

            // Debugging: Lihat data sebelum dikirim ke MQTT
            // dd($data);

            $topic = 'amantuzh';
            $message = json_encode($data); // Ubah menjadi $data, bukan $validatedData

            // Pastikan mqttService telah di-inject dan tersedia
            if (!isset($this->mqttService)) {
                throw new \Exception('MQTT Service is not initialized.');
            }

            // Kirim pesan ke broker MQTT dengan menggunakan mqttService
            if ($this->mqttService->publish($topic, $message)) {
                return response()->json(['message' => 'Data sent successfully'], 200);
            } else {
                return response()->json(['message' => 'Failed to send data'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat mengirim data ke MQTT:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while sending data to MQTT.'], 500);
        }
    }

    public function getData()
    {
        try {
            $this->mqttService->subscribe('postdataGluc', function ($topic, $message) {
                // Decode JSON message
                $data = json_decode($message, true);

                if ($data && isset($data['id'], $data['BPM'], $data['SpO2'], $data['PredictedGlucose'])) {
                    // Insert data into the 'penyakits' table
                    Penyakit::create([
                        'id_pasien' => $data['id'],
                        'bpm' => $data['BPM'],
                        'spo2' => $data['SpO2'],
                        'gula_darah' => $data['PredictedGlucose']
                    ]);
                } else {
                    // Handle invalid data
                    throw new \Exception('Invalid data received from MQTT topic.');
                }
            });

            return response()->json(['message' => 'Subscribed and received message successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while subscribing to MQTT.'], 500);
        }
    }
}
