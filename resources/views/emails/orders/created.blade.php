<x-mail::message>
# Pesanan Anda Diterima 🎉

Halo {{ $order->user?->name ?? 'Pelanggan' }},

Pesanan Anda sudah kami terima.
Silakan unggah bukti pembayaran di halaman **Riwayat → Transaksi**.

**Kode Pesanan:** {{ $order->code ?? $order->order_code }}  
**Rute:** {{ optional($order?->ticket?->track)->from_route }} → {{ optional($order?->ticket?->track)->to_route }}  
**Tanggal Berangkat:** {{ $order?->go_date ?? '-' }}  
**Kursi:** {{ $order->selected_seats ?? '-' }}  
**Total:** Rp {{ number_format( (optional($order->transaction)->total) ?? (($order->ticket?->price?->price ?? 0) * (int)($order->amount ?? 1)), 0, ',', '.') }}

<x-mail::button :url="route('transactions.index')">
Unggah Bukti Pembayaran
</x-mail::button>

Tunggu email dari kami untuk update status pembayaran Anda.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
