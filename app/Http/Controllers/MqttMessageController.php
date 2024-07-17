<?php

namespace App\Http\Controllers;

use App\Models\MqttMessage;
use Illuminate\Http\Request;

class MqttMessageController extends Controller
{
    public function index()
    {
        $messages = MqttMessage::all();
        return view('mqtt_index', compact('messages'));
    }
}
