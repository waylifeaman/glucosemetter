<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class pengguna extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $i = 1;
        $user = User::all();
        return view('pengguna', compact('user', 'i'));
    }
    public function create()
    {
        return view('profile');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|numeric',
        ]);
        User::create($request->all());
        return redirect()->route('pasien.index')->with('Success', 'Berhasil Tambah Data');
    }

    public function showProfileForm()
    {
        $user = auth()->user();
        return view('profile', compact('user'), ['title' => 'Ubah Profile']);
    }
    public function updateProfile(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(), // Email harus unik kecuali untuk user yang sedang login
            'password' => 'nullable|string|min:8|confirmed', // Password minimal 8 karakter, opsional
        ]);

        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Perbarui nama dan email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Perbarui password jika ada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('profile', compact('pasien'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        $disable = ['disabled' => 'disabled'];
        return view('pasien_edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'numeric',
        ]);
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('pengguna.index')->with('Success', 'Berhasil Update Data');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('pengguna.index')->with('Succes', 'Data Dihapus');
    }

    public function hapus($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('pengguna.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pengguna.index')->with('error', 'Gagal menghapus user.');
        }
    }


    // public function detail($id)
    // {
    //     $pasien = User::find($id);
    //     return view('pasien_detail', compact('pasien'));
    // }
}
