<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DriverAuthController extends Controller
{
    public function showLogin()
{
    if (Auth::guard('driver')->check()) {
        return redirect()->route('driver.dashboard');
    }
    return view('auth.driver.login');
}


    public function login(Request $request)
{
    // Ambil dari salah satu: login | username | email
    $login = $request->input('login') ?? $request->input('username') ?? $request->input('email');

    // Satukan ke 'login' agar validasi & logika di bawah tetap konsisten
    $request->merge(['login' => $login]);

    $request->validate([
        'login'    => ['required','string'], // bisa username ATAU email
        'password' => ['required','string'],
        'remember' => ['nullable','boolean'],
    ], [
        'login.required' => 'Email atau username wajib diisi.',
    ]);

    // Deteksi email atau username
    $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    // Jika tabel drivers tidak punya kolom 'username', jatuhkan ke 'nama_driver'
    if ($field === 'username' && !\Schema::hasColumn('drivers', 'username')) {
        $field = 'nama_driver';
    }

    if (Auth::guard('driver')->attempt(
        [$field => $request->login, 'password' => $request->password],
        $request->boolean('remember')
    )) {
        $request->session()->regenerate();
        return redirect()->intended(route('driver.dashboard'));
    }

    return back()
        ->withErrors(['login' => 'Kredensial salah atau akun tidak ditemukan.'])
        ->onlyInput('login');
}



    public function showRegister()   { return view('auth.driver.register'); }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_driver' => ['required','string','max:100'],
            'username'    => ['required','string','max:50', Rule::unique('drivers','username')],
            'email'       => ['required','email','max:150', Rule::unique('drivers','email')],
            'password'    => ['required','string','min:6','confirmed'],
            'no_telepon'  => ['nullable','string','max:30'],
            'sim'         => ['nullable','string','max:50'],
            'foto'        => ['nullable','image','max:2048'],
        ]);

        $path = $request->hasFile('foto')
            ? $request->file('foto')->store('drivers', 'public')
            : null;

        $driver = Driver::create([
            'nama_driver' => $data['nama_driver'],
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'no_telepon'  => $data['no_telepon'] ?? null,
            'sim'         => $data['sim'] ?? null,
            'foto'        => $path,
        ]);

        Auth::guard('driver')->login($driver);
        return redirect()->route('driver.dashboard')->with('success','Akun driver berhasil dibuat.');
    }

    public function logout(Request $request)
    {
        Auth::guard('driver')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('driver.login');
    }
}
