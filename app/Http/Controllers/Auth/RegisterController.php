<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Topic; // Tambahkan ini
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/pasien';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $topics = Topic::all(); // Ambil semua data instansi dari tabel topics

        return view('auth.register', compact('topics'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'id_topic' => ['required', 'exists:topics,id'], // Validasi bahwa id_topic ada dalam tabel topics
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        Log::info('Creating user with data:', $data); // Tambahkan log untuk melihat data yang diterima

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_topic' => $data['id_topic'], // Masukkan id_topic ke dalam data user yang akan disimpan
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi data yang diterima dari request
        $this->validator($request->all())->validate();

        // Buat user baru
        $user = $this->create($request->all());

        // Kirim event Registered untuk mengirim email verifikasi
        event(new Registered($user));

        // Logout pengguna setelah registrasi dan kirim mereka ke halaman login
        return redirect('/login')->with('status', 'Kami telah mengirimkan kode aktivasi ke email Anda. Silakan cek email Anda.');
    }

    /**
     * Handle a registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return void
     */
    protected function registered(Request $request, $user)
    {
        // Method ini dapat dikosongkan atau digunakan untuk logika tambahan jika diperlukan.
    }
}
