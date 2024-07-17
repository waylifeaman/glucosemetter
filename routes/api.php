<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\penyakitController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// routes/api.php
Route::post('data', [DataController::class, 'store']);


Route::get('data', [DataController::class, 'index']);


Route::post('/', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Storage::append(
        "arduino-log.txt",
        "Time: " . now()->format("Y-m-d H:i:s") . ', ' .
            "Temperature: " . $request->get("temperature", "n/a") . '°C, ' .
            "Humidity: " . $request->get("humidity", "n/a") . '%'
    );
});



Route::post('/dataa', function (Request $request) {
    $temperature = $request->input('temperature');
    $humidity = $request->input('humidity');

    // Proses data dan kembalikan respons
    return response()->json([
        'temperature' => $temperature,
        'humidity' => $humidity,
        'message' => 'Data received successfully'
    ]);
});


Route::post('/penyakits', [penyakitController::class, 'store']);
