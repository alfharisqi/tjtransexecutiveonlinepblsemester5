@extends('layouts.front')

@section('front')

<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 15mm; /* Beri margin semua sisi */
        }

        body {
            font-size: 9px;
            margin: 0;
        }

        .invoice {
            margin: 0 15mm; /* Tambahkan margin kiri-kanan eksplisit */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            word-break: break-word;
        }

        h2.page-header img {
            max-width: 120px;
            height: auto;
        }
    }

    .invoice {
        margin: 20px auto;
        max-width: 180mm; /* Batasi lebar supaya tidak tembus A4 (210mm - margin) */
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>


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
                        {{ $order->user->name ?? '-' }}<br>
                        {{ $order->user->email ?? '-' }}
                    </address>
                </div>

                <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{ $order->order_code }}</b><br>
                    <b>Order ID:</b> {{ $order->order_code }}<br>
                    @isset($order->transaction->method->method)
                        <b>Pembayaran:</b> {{ $order->transaction->method->method }}<br>
                    @endisset
                    <b>Tanggal Bayar:</b> {{ $order->transaction->updated_at }}
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
                                    @if ($order->passengers->count())
                                        @foreach ($order->passengers as $index => $passenger)
                                            {{ $index + 1 }}. {{ $passenger->name }} ({{ $passenger->gender ? 'L' : 'P' }})<br>
                                        @endforeach
                                    @else
                                        Tidak ada data
                                    @endif
                                </td>
                                                    <td>
                                                        @if (!empty($order->selected_seats))
                                                            {{ implode(', ', $order->selected_seats) }}
                                                        @else
                                                            Tidak ada kursi
                                                        @endif
                                                    </td>

                                <td>{{ $order->alamat_lengkap ?? '-' }}</td>
                                <td>{{ $order->ticket->train->name ?? '-' }}</td>
                                <td>{{ $order->ticket->train->class ?? '-' }}</td>
                                <td>
                                    @isset($order->ticket->track->from_route, $order->ticket->track->to_route)
                                        {{ $order->ticket->track->from_route }} - {{ $order->ticket->track->to_route }}
                                    @else
                                        -
                                    @endisset
                                </td>
                                <td>{{ $order->go_date ?? '-' }}</td>
                            </tr>
                            <!-- TOTAL row -->
                            <tr>
                                <td colspan="8" style="text-align: right; font-weight: bold;">Total:</td>
                                <td style="font-weight: bold;">Rp {{ $order->transaction->total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

@endsection

<script type="text/javascript">
    window.print();
</script>
