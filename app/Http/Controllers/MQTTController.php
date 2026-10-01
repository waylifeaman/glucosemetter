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
