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
