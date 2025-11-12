<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')) {
            return view('dashboard.user.index', [
                'users' => User::all()
            ]);
        } else {
            return redirect('users/' . Auth::id());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (Gate::allows('isAdmin')) {
            return view('dashboard.profile.index', [
                'user' => $user
            ]);
        } else {
            if (Auth::id() != $user->id) {
                return redirect('/users' . '/' . Auth::id());
            }

            return view('dashboard.profile.index', [
                'user' => $user
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name'         => ['required', 'min:5', 'max:100'],
            'phone_number' => ['required', 'min:10', 'max:100'],
            'gender'       => ['required'],
            'image'        => ['nullable', 'image', 'max:4096'], // tambahkan validasi image di sini
        ]);
    
        $validatedData['gender'] = (int)$validatedData['gender'] === 1;
    
        // Jika upload foto baru
        if ($request->hasFile('image')) {
    
            // Hapus foto lama (jika ada)
            if (!empty($user->image)) {
                \Storage::disk('public')->delete($user->image);  // $user->image berisi "profiles/namafile.jpg"
            }
    
            // Simpan ke disk 'public' agar bisa diakses via /storage/...
            // Hasil return: "profiles/xxxx.jpg"
            $path = $request->file('image')->store('profiles', 'public');
    
            // Simpan path RELATIF ke DB (tanpa "storage/" atau path absolut)
            $validatedData['image'] = $path;
    
            // Catatan penting:
            // TIDAK perlu pakai move() ke public_path(). Biarkan di storage/app/public/profiles.
            // Aksesnya via symlink /public_html/storage (php artisan storage:link).
        }
    
        $user->update($validatedData);
    
        return Gate::allows('isAdmin')
            ? redirect('/users')->with('update', 'Data user berhasil diubah')
            : redirect('/users/'.Auth::id());
    }


    public function deleteImage(Request $request)
    {
        $user = User::findOrFail(Auth::id());
    
        if ($user->image) {
            \Storage::disk('public')->delete($user->image); // JANGAN tambahkan 'public/' lagi
            $user->image = null;
            $user->save();
        }
    
        return Gate::allows('isAdmin')
            ? redirect('/users')->with('update', 'Foto profil dihapus')
            : redirect('/users/'.Auth::id());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Gate::allows('isAdmin')) {
            $user->delete();
            return redirect('/users')->with('delete', 'Data user berhasil dihapus');
        } else {
            return redirect('/users' . '/' . Auth::id());
        }
    }
}
