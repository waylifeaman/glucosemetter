<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MQTTService;
use Illuminate\Foundation\Auth\User;

class MQTTController extends Controller
{
    protected $mqttService;

    public function __construct(MQTTService $mqttService)
    {
        $this->mqttService = $mqttService;
    }
    // public function sendData(Request $request)
    // {
    //     // Ambil ID dari user yang sedang aktif
    //     $userId = auth()->id();

    //     // Ambil user berdasarkan ID
    //     $user = User::findOrFail($userId);

    //     // Ambil topic_pub dari relasi topic user
    //     $topic = $user->topic->topic_pub;

    //     $data = [
    //         'id' => $request->input('id'),
    //         'nama' => $request->input('nama')
    //     ];

    //     $message = json_encode($data);

    //     if ($this->mqttService->publish($topic, $message)) {
    //         return response()->json(['message' => 'Data sent successfully'], 200);
    //     } else {
    //         return response()->json(['message' => 'Failed to send data'], 500);
    //     }
    // }




    public function sendData(Request $request)
    {
        $data = [
            'id' => $request->input('id'),
            'nama' => $request->input('nama')
        ];

        $topic = 'amantuzh';
        // $topic = 'poltekPub';
        $message = json_encode($data);

        if ($this->mqttService->publish($topic, $message)) {
            return response()->json(['message' => 'Data sent successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to send data'], 500);
        }
    }
}
