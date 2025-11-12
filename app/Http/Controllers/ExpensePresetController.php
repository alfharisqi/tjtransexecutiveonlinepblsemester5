<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensePreset;

class ExpensePresetController extends Controller
{
    /**
     * Simpan preset biaya baru.
     * Route: POST /expense-presets  (name: expense_presets.store)
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'name'                 => 'required|string|max:100',
        'amount'               => 'required|integer|min:0',
        'vehicle_type'         => 'nullable|string|max:50',
        'is_active'            => 'nullable|in:0,1',      // <= ganti dari boolean
        'amortization_cycles'  => 'nullable|integer|min:1',
    ]);

    // paksa ke bool (true jika "1")
    $data['is_active'] = $request->boolean('is_active');

    \App\Models\ExpensePreset::create($data);

    return back()->with('ok', 'Preset biaya ditambahkan.');
}


    /**
     * Hapus preset biaya.
     * Route: DELETE /expense-presets/{preset}  (name: expense_presets.destroy)
     */
    public function destroy(ExpensePreset $preset)
    {
        $preset->delete();
        return back()->with('ok', 'Preset biaya dihapus.');
    }
}
