<?php

namespace App\Http\Controllers;

use App\Models\Method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MethodController extends Controller
{
    public function index()
    {
        return view('dashboard.method.index', [
            'methods' => Method::all()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'method'         => ['required', 'min:3', 'max:50'],
            'target_account' => ['required', 'min:3', 'max:50'],
            'foto_method'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $check = Method::where('method', $request['method'])->first();
        if ($check) {
            return redirect('/methods')->with('sameMethod', 'Metode Pembayaran tersebut sudah ada di database!');
        }

        if ($request->hasFile('foto_method')) {
            $validatedData['foto_method'] = $request->file('foto_method')->store('methods', 'public');
        }

        Method::create($validatedData);

        return redirect('/methods')->with('update', 'Metode Pembayaran berhasil ditambahkan!');
    }

    public function edit(Method $method)
    {
        return view('dashboard.method.edit', compact('method'));
    }

    public function update(Request $request, Method $method)
    {
        $validatedData = $request->validate([
            'method'         => ['required', 'min:3', 'max:50'],
            'target_account' => ['required', 'min:3', 'max:50'],
            'foto_method'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $check = Method::where('id', '!=', $method->id)->where('method', $request['method'])->first();
        if ($check) {
            return redirect('/methods')->with('sameMethod', 'Metode pembayaran tersebut sudah ada di database!');
        }

        if ($request->hasFile('foto_method')) {
            if ($method->foto_method && Storage::disk('public')->exists($method->foto_method)) {
                Storage::disk('public')->delete($method->foto_method);
            }
            $validatedData['foto_method'] = $request->file('foto_method')->store('methods', 'public');
        }

        $method->update($validatedData);

        return redirect('/methods')->with('update', 'Metode Pembayaran berhasil diubah!');
    }

    public function destroy(Method $method)
    {
        if ($method->foto_method && Storage::disk('public')->exists($method->foto_method)) {
            Storage::disk('public')->delete($method->foto_method);
        }

        $method->delete();
        return redirect('/methods')->with('delete', 'Metode Pembayaran berhasil dihapus!');
    }
}
