@component('mail::message')
# Pembayaran Anda Telah Disetujui ✅

Halo {{ $order?->user?->name ?? 'Pelanggan' }},

Pembayaran untuk pesanan Anda **telah disetujui**. Tiket/booking kini aktif dan siap digunakan.

**Kode Pesanan:** {{ $order->order_code ?? $trx->id }}  
**Rute:** {{ optional($order?->ticket?->track)->from_route }} → {{ optional($order?->ticket?->track)->to_route }}  
**Jadwal Berangkat:** {{
    optional($order?->ticket?->departure_at)?->timezone('Asia/Jakarta')?->format('d M Y H:i')
    ?? ($order?->go_date ?? '-')
}}  
**Perkiraan Tiba:** {{
    optional($order?->ticket?->arrival_at)?->timezone('Asia/Jakarta')?->format('d M Y H:i')
    ?? '-'
}}  
**Armada/Kelas:** {{ optional($order?->ticket?->train)->name ?? '-' }} ({{ optional($order?->ticket?->train)->class ?? '-' }})  
**Kursi:** {{ $order->selected_seats ?? '-' }}  
**Total Dibayar:** Rp {{ number_format($trx->total ?? 0, 0, ',', '.') }}

{{-- ================== Metode Pembayaran + Foto (Tambahan) ================== --}}
@php
    // Coba ambil objek Method dari relasi yang tersedia
    // Sesuaikan dengan relasi di project kamu:
    // - $order->method   atau
    // - $trx->method     atau
    // - pakai id: $order->method_id / $trx->method_id (jika perlu, load dulu di Mailable)
    $methodObj = $order->method ?? ($trx->method ?? null);

    // Fallback jika hanya ada id:
    if (!$methodObj && !empty($order?->method_id ?? $trx?->method_id ?? null)) {
        try {
            $methodObj = \App\Models\Method::find($order->method_id ?? $trx->method_id);
        } catch (\Throwable $e) {
            $methodObj = null;
        }
    }

    $methodName   = $methodObj->method ?? ($trx->method_name ?? null) ?? '-';
    $methodTarget = $methodObj->target_account ?? ($trx->target_account ?? null) ?? '-';
    $fotoMethod   = !empty($methodObj?->foto_method) ? asset('storage/'.$methodObj->foto_method) : null;
@endphp

**Metode Pembayaran:** {{ $methodName }}  
**Rekening Tujuan:** {{ $methodTarget }}

@isset($fotoMethod)
<p style="margin: 8px 0 0;">
    <img src="{{ $fotoMethod }}" alt="Metode: {{ $methodName }}" style="max-width: 280px; height: auto; border-radius: 8px;">
</p>
@endisset
{{-- ================== /Metode Pembayaran + Foto ================== --}}

@isset($order)
@component('mail::button', ['url' => route('orders.show', $order)])
Lihat Detail Pesanan
@endcomponent
@endisset

@component('mail::button', ['url' => route('transactions.index')])
Riwayat Transaksi
@endcomponent

**Catatan penting:**
- Mohon datang lebih awal untuk proses boarding.
- Simpan email ini sebagai bukti.  
- Jika ada perubahan jadwal atau pertanyaan, balas email ini atau hubungi layanan pelanggan kami.

Terima kasih telah memilih **Terus Jaya Trans Executive**.
@endcomponent
