<?php

use App\Http\Controllers\pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\penyakitController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\MQTTController;

Route::get('logout-user', function () {
    Auth::logout();
    return redirect('/');
})->name('logout-user');

Auth::routes();

Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\PasienController::class, 'index'])->name('home')->middleware('verified'); // Pastikan middleware 'verified' digunakan

Route::resource('/', PasienController::class);
Route::resource('pasien', PasienController::class);

Route::get('pasien-data', [PasienController::class, 'index'])->name('pasien');
Route::get('/pasien/update/{id}', [PasienController::class, 'show'])->name('pasien.show');
Route::delete('/pasien/hapus/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
Route::put('/pasien/{id}', 'PasienController@update')->name('pasien.update');

Route::resource('penyakit', penyakitController::class);
Route::get('/penyakit/{id}/show', [PenyakitController::class, 'show'])->name('penyakit.show');
Route::get('penyakit/{id}/create', [penyakitController::class, 'create'])->name('penyakit.create');
Route::get('/penyakit', [penyakitController::class, 'index'])->name('penyakit.index');
Route::get('/pengguna', [pengguna::class, 'index'])->name('pengguna.index');
Route::get('/penyakit/realtime/{id_pasien}', [penyakitController::class, 'getRealtimeData']);
Route::get('/penyakit/realtime-table/{id_pasien}', [penyakitController::class, 'getRealtimeTableData']);
Route::get('/penyakit/realtime-table/{id}', [penyakitController::class, 'getRealtimeTableData']);
Route::get('/penyakit/realtime/{id}', [penyakitController::class, 'getRealtimeData']);
Route::get('/chart/data/{id_pasien}', [penyakitController::class, 'updateChart']);

Route::get('/profile/form', [pengguna::class, 'showProfileForm'])->name('profile.form');
Route::put('/profile/update', [pengguna::class, 'updateProfile'])->name('profile.update');
Route::resource('pengguna', pengguna::class);
Route::delete('/pengguna/{pengguna}', [pengguna::class, 'destroy'])->name('pengguna.destroy');
Route::delete('/pengguna/{id}', 'pengguna@hapus')->name('hapus.pengguna');



Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');



Route::post('/send-data', [penyakitController::class, 'sendData'])->name('sendData');
Route::get('/mqtt/get-data', [penyakitController::class, 'getData']);





Route::get('/mqtt-form', function () {
    return view('home');
});

Route::post('/send-dat', [MQTTController::class, 'sendData']);



Route::get('/publish', [MQTTController::class, 'publish']);
Route::get('/subscribe', [MQTTController::class, 'subscribe']);

Route::get('/publish', function () {
    return view('home');
});

Route::post('/publish', [MQTTController::class, 'publish']);

use App\Http\Controllers\MqttMessageController;

Route::get('/messages', [MqttMessageController::class, 'index']);
