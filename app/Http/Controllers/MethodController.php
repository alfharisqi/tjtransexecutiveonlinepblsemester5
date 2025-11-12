<?php

namespace App\Http\Controllers;

use App\Models\Method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MethodController extends Controller
{
    /**
     * Tampilkan daftar metode pembayaran.
     */
    public function index()
    {
        return view('dashboard.method.index', [
            'methods' => Method::latest()->get(),
        ]);
    }

    /**
     * Form tambah (opsional, jika diperlukan view terpisah).
     */
    public function create()
    {
        return view('dashboard.method.create');
    }

    /**
     * Simpan metode baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'method'         => ['required', 'string', 'min:3', 'max:50'],
            'target_account' => ['required', 'string', 'min:3', 'max:100'],
            'foto_method'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Cek duplikasi nama method
        if (Method::where('method', $validated['method'])->exists()) {
            return redirect()
                ->route('methods.index')
                ->with('sameMethod', 'Metode Pembayaran tersebut sudah ada di database!');
        }

        // Upload gambar (jika ada)
        if ($request->hasFile('foto_method')) {
            $validated['foto_method'] = $request->file('foto_method')->store('methods', 'public'); // "methods/xxx.jpg"
        }

        Method::create($validated);

        return redirect()
            ->route('methods.index')
            ->with('update', 'Metode Pembayaran berhasil ditambahkan!');
    }

    /**
     * Form edit metode.
     */
    public function edit(Method $method)
    {
        return view('dashboard.method.edit', compact('method'));
    }

    /**
     * Update metode pembayaran.
     */
    public function update(Request $request, Method $method)
    {
        $validated = $request->validate([
            'method'         => ['required', 'string', 'min:3', 'max:50'],
            'target_account' => ['required', 'string', 'min:3', 'max:100'],
            'foto_method'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Cek duplikasi nama method (kecuali dirinya sendiri)
        $exists = Method::where('id', '!=', $method->id)
            ->where('method', $validated['method'])
            ->exists();

        if ($exists) {
            return redirect()
                ->route('methods.index')
                ->with('sameMethod', 'Metode pembayaran tersebut sudah ada di database!');
        }

        // Jika upload gambar baru: hapus lama lalu simpan baru
        if ($request->hasFile('foto_method')) {
            if ($method->foto_method && Storage::disk('public')->exists($method->foto_method)) {
                Storage::disk('public')->delete($method->foto_method);
            }
            $validated['foto_method'] = $request->file('foto_method')->store('methods', 'public');
        }

        $method->update($validated);

        return redirect()
            ->route('methods.index')
            ->with('update', 'Metode Pembayaran berhasil diubah!');
    }

    /**
     * Hapus metode + file fotonya.
     */
    public function destroy(Method $method)
    {
        if ($method->foto_method && Storage::disk('public')->exists($method->foto_method)) {
            Storage::disk('public')->delete($method->foto_method);
        }

        $method->delete();

        return redirect()
            ->route('methods.index')
            ->with('delete', 'Metode Pembayaran berhasil dihapus!');
    }
}
