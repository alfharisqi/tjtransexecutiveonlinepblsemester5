<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->get();
        return view('dashboard.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('dashboard.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:drivers,email',
            'username'     => 'required|string|max:50|unique:drivers,username',
            'password'     => 'nullable|string|min:6',
            'phone_number' => 'nullable|string|max:30',
            'sim'          => 'nullable|string|max:50',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $path = $request->hasFile('foto')
            ? $request->file('foto')->store('drivers', 'public')
            : null;

        Driver::create([
            'nama_driver' => $request->name,
            'username'    => $request->username ?: $request->email,
            'email'       => $request->email,
            'password'    => Hash::make($request->password ?: 'password123'),
            'no_telepon'  => $request->phone_number,
            'sim'         => $request->sim,
            'foto'        => $path,
        ]);

        return redirect()->route('drivers.index')->with('success','Driver berhasil ditambahkan');
    }

    public function edit(Driver $driver)
    {
        return view('dashboard.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:drivers,email,' . $driver->id,
            'username'     => 'required|string|max:50|unique:drivers,username,' . $driver->id,
            'password'     => 'nullable|string|min:6',
            'phone_number' => 'nullable|string|max:30',
            'sim'          => 'nullable|string|max:50',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama_driver' => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'no_telepon'  => $request->phone_number,
            'sim'         => $request->sim,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($driver->foto) {
                Storage::disk('public')->delete($driver->foto);
            }
            $data['foto'] = $request->file('foto')->store('drivers','public');
        }

        $driver->update($data);

        return redirect()->route('drivers.index')->with('success','Driver berhasil diupdate');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->foto) {
            Storage::disk('public')->delete($driver->foto);
        }
        $driver->delete();

        return redirect()->route('drivers.index')->with('success','Driver berhasil dihapus');
    }
}
