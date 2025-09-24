<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionApprovedMail;

class TransactionController extends Controller
{
    /**
     * Tampilkan daftar transaksi.
     */
    public function index()
    {
        // Eager-load relasi agar efisien di view
        $base = Transaction::with([
            'order.ticket.train',
            'order.ticket.track',
            'order.user',
        ])->latest();

        if (Gate::allows('isAdmin')) {
            $transactions = $base->get();
        } else {
            $transactions = $base->whereHas('order', function ($q) {
                $q->where('user_id', Auth::id());
            })->get();
        }

        return view('dashboard.transaction.index', compact('transactions'));
    }

    /**
     * Form edit transaksi (status atau bukti pembayaran).
     */
    public function edit(Transaction $transaction)
    {
        // Hanya pemilik atau admin yang boleh melihat form
        if (!Gate::allows('isAdmin') && optional($transaction->order)->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dashboard.transaction.edit', [
            'transaction' => $transaction->load(['order.ticket.train','order.ticket.track']),
        ]);
    }

    /**
     * Update transaksi.
     * - Admin: update status (boolean) + kirim email jika baru disetujui.
     * - User: upload bukti pembayaran (image).
     */
    public function update(Request $request, Transaction $transaction)
    {
        // === ADMIN: update status ===
        if (Gate::allows('isAdmin')) {
            $wasApproved = (bool) $transaction->status;     // status sebelum update
            $nowApproved = $request->boolean('status');     // hasil dari form (hidden 0 + checkbox 1)

            $transaction->status = $nowApproved;
            $transaction->save();

            // Jika baru disetujui (false -> true), kirim email ke pemilik order
            if (!$wasApproved && $nowApproved) {
                $user = optional($transaction->order)->user;
                if ($user?->email) {
                    try {
                        Mail::to($user->email)->send(new TransactionApprovedMail($transaction));
                    } catch (\Throwable $e) {
                        \Log::warning('Gagal kirim email approved: '.$e->getMessage());
                    }
                }
            }

            return redirect()->route('transactions.index')
                ->with('success', 'Status transaksi berhasil diperbarui.');
        }

        // === USER: upload bukti pembayaran ===
        if (optional($transaction->order)->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi & simpan bukti pembayaran
        $validated = $request->validate([
            'image' => ['required','image','max:4096'], // max 4MB
        ]);

        // Simpan ke storage/app/public/public_payment/xxxx.jpg
        // Pastikan sudah menjalankan: php artisan storage:link
        $path = $request->file('image')->store('public_payment', 'public'); // return: public_payment/xxxx.jpg

        $transaction->update([
            'image' => $path, // akses di Blade: asset('storage/'.$transaction->image)
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    /**
     * (Opsional) Hapus transaksi — biasanya tidak dipakai publik.
     */
    public function destroy(Transaction $transaction)
    {
        if (!Gate::allows('isAdmin')) {
            abort(403);
        }
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
