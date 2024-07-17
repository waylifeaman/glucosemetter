<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $i = 1;
        $userId = Auth::id();
        $pasien = Pasien::where('id_user', $userId)->get();

        // $serverIp = request()->server('SERVER_ADDR');
        // Log::info('Server IP Address: ' . $serverIp);

        return view('pasien', compact('pasien', 'i'));
    }

    public function create()
    {
        return view('pasien_form');
    }

    public function store(Request $request)
    {
        // Validasi input termasuk alamat
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|numeric|min:0',
            'phone' => 'required|numeric|digits_between:10,15',
            'alamat' => 'required|string|max:255', // Validasi untuk alamat
        ]);

        // Menambahkan data pasien dengan id_user dari pengguna yang sedang login
        Pasien::create([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'phone' => $request->input('phone'),
            'alamat' => $request->input('alamat'), // Menyimpan alamat
            'id_user' => auth()->id(), // Menggunakan ID pengguna yang sedang login
        ]);

        return redirect()->route('pasien.index')->with('success', 'Berhasil Tambah Data');
    }

    public function show($id)
    {
        $pasien = Pasien::where('id', $id)->where('id_user', Auth::id())->firstOrFail();
        return view('pasien_edit', compact('pasien'));
    }

    public function edit($id)
    {
        $pasien = Pasien::where('id', $id)->where('id_user', Auth::id())->firstOrFail();
        return view('pasien_edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input termasuk alamat
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'numeric|min:0',
            'phone' => 'numeric|digits_between:10,15',
            'alamat' => 'required|string|max:255', // Validasi untuk alamat
        ]);

        $pasien = Pasien::where('id', $id)->where('id_user', Auth::id())->firstOrFail();

        // Update data pasien termasuk alamat
        $pasien->update($request->all());

        return redirect()->route('pasien.index')->with('success', 'Berhasil Update Data');
    }

    public function destroy($id)
    {
        $pasien = Pasien::where('id', $id)->where('id_user', Auth::id())->firstOrFail();
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Berhasil Hapus Data');
    }
}
