@extends('layouts.front')

@section('front')

<style>
    @media print {
        @page {
            size: A4 portrait; /* tetap portrait */
            margin: 15mm;
        }
        body { font-size: 9px; margin: 0; }
        .invoice { margin: 0 15mm; }
        table { width: 100%; border-collapse: collapse; font-size: 8px; }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            word-break: break-word;
        }
        h2.page-header img { max-width: 90px; height: auto; } /* kecilkan logo saat print */
    }

    .invoice {
        margin: 20px auto;
        max-width: 180mm; /* tetap sesuai A4 */
    }
    .table-responsive { overflow-x: auto; }

    /* layar biasa juga kecilkan logo */
    h2.page-header img { max-width: 110px; height: auto; }
</style>

@php
    // Seats: dukung array / JSON / string "A1,B2"
    $seatsRaw = $order->selected_seats ?? [];
    if (is_string($seatsRaw)) {
        $decoded = json_decode($seatsRaw, true);
        $seats = is_array($decoded) ? $decoded : (strlen(trim($seatsRaw)) ? explode(',', $seatsRaw) : []);
    } elseif (is_array($seatsRaw)) {
        $seats = $seatsRaw;
    } else {
        $seats = [];
    }
    $seats = array_values(array_filter(array_map('trim', $seats)));

    // Null-safe short vars
    $user  = $order->user ?? null;
    $trx   = $order->transaction ?? null;
    $methodName = optional(optional($trx)->method)->method;

    // Tanggal bayar aman
    try {
        $paidAtStr = optional($trx && $trx->updated_at ? \Carbon\Carbon::parse($trx->updated_at) : null)?->format('d M Y H:i') ?? '-';
    } catch (\Throwable $e) {
        $paidAtStr = $trx->updated_at ?? '-';
    }

    // Total aman + format
    $totalStr = 'Rp ' . number_format((float)($trx->total ?? 0), 0, ',', '.');

    $ticket = $order->ticket ?? null;
    $train  = optional($ticket)->train;
    $track  = optional($ticket)->track;
    $ruteStr = ($track && ($track->from_route ?? null) && ($track->to_route ?? null))
        ? ($track->from_route.' - '.$track->to_route)
        : '-';

    // Tanggal jalan aman
    try {
        $goDateStr = $order->go_date ? \Carbon\Carbon::parse($order->go_date)->format('d M Y') : '-';
    } catch (\Throwable $e) {
        $goDateStr = $order->go_date ?? '-';
    }
@endphp

<div class="wrapper">
    <section class="invoice">
        <div class="row">
            <div class="col-12">
                <h2 class="page-header">
                    <img src="{{ asset('images/tjulogo.png') }}" alt="Tjtrans Logo">
                </h2>
            </div>
        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>TJ Trans Executive</strong><br>
                    Bukit Tinggi, Kalimantan Tengah<br>
                    Telp: 081384002161<br>
                    Email: tjtransexecutive@gmail.com
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                <address>
                    {{ $user->name ?? '-' }}<br>
                    {{ $user->email ?? '-' }}
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                <b>Invoice #{{ $order->order_code ?? '-' }}</b><br>
                <b>Order ID:</b> {{ $order->order_code ?? '-' }}<br>
                @if ($methodName)
                    <b>Pembayaran:</b> {{ $methodName }}<br>
                @endif
                <b>Tanggal Bayar:</b> {{ $paidAtStr }}
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-12 table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Booking</th>
                            <th>Penumpang</th>
                            <th>Kursi</th>
                            <th>Penjemputan</th>
                            <th>Armada</th>
                            <th>Kelas</th>
                            <th>Rute</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $order->order_code ?? '-' }}</td>
                            <td>
                                @if (!empty($order->passengers) && $order->passengers->count())
                                    @foreach ($order->passengers as $i => $passenger)
                                        {{ $i + 1 }}. {{ $passenger->name ?? '-' }}
                                        ({{ isset($passenger->gender) ? ($passenger->gender ? 'L' : 'P') : '-' }})<br>
                                    @endforeach
                                @else
                                    Tidak ada data
                                @endif
                            </td>
                            <td>{{ $seats ? implode(', ', $seats) : 'Tidak ada kursi' }}</td>
                            <td>{{ $order->alamat_lengkap ?? '-' }}</td>
                            <td>{{ optional($train)->name ?? '-' }}</td>
                            <td>{{ optional($train)->class ?? '-' }}</td>
                            <td>{{ $ruteStr }}</td>
                            <td>{{ $goDateStr }}</td>
                        </tr>

                        <tr>
                            <td colspan="8" style="text-align:right; font-weight:bold;">Total:</td>
                            <td style="font-weight:bold;">{{ $totalStr }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

@endsection

<script type="text/javascript">
    // Biarkan seperti layout sebelumnya (langsung print)
    window.print();
</script>
