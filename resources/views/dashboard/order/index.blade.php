@extends('layouts.front')

@section('front')
    <div class="wrapper">
        <!-- Navbar -->
        <x-front-dashboard-navbar></x-front-dashboard-navbar>
        <!-- /.Navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">
                <img src="{{ asset('favicon.ico') }}" alt="TJ Trans Executive Logo"
                     class="brand-image img-circle elevation-3" style="opacity:.8">
                <span class="brand-text font-weight-light">TJ Trans Executive</span>
            </a>

            <!-- Sidebar Menu -->
            <x-front-sidemenu></x-front-sidemenu>
            <!-- /.sidebar Menu -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Riwayat Pesanan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Riwayat Pesanan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            @if (session('hapus'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('hapus') }}
                                </div>
                            @endif

                            @if (session('lapor'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('lapor') }}
                                </div>
                            @endif

                            @if (session('paymentCheckFailed'))
                                <div class="alert alert-warning" role="alert">
                                    {{ session('paymentCheckFailed') }}
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Riwayat Pesanan</h3>
                                </div>

                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Booking</th>
                                            <th>Nama</th>
                                            <th>Nama Kereta</th>
                                            <th>Kelas</th>
                                            <th>Rute</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Status Perjalanan</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    @isset($order->order_code)
                                                        {{ $order->order_code }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endisset
                                                </td>

                                                <td>
                                                    @isset($order->user->name)
                                                        {{ $order->user->name }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endisset
                                                </td>

                                                <td>
                                                    @isset($order->ticket->train->name)
                                                        {{ $order->ticket->train->name }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endisset
                                                </td>

                                                <td>
                                                    @isset($order->ticket->train->class)
                                                        {{ $order->ticket->train->class }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endisset
                                                </td>

                                                <td>
                                                    @isset($order->ticket->track->from_route)
                                                        @isset($order->ticket->track->to_route)
                                                            {{ $order->ticket->track->from_route }} -
                                                            {{ $order->ticket->track->to_route }}
                                                        @endisset
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endisset
                                                </td>

                                                <td>
                                                    @isset($order->amount)
                                                        {{ $order->amount }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endisset
                                                </td>

                                                <td>
                                                    @isset($order->updated_at)
                                                        {{ $order->updated_at }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endisset
                                                </td>

                                                <td>
                                                    @php
                                                        $statusRow = $order->statusPerjalanan ?? null;
                                                        $status    = $statusRow?->status ?? ($order->status_perjalanan ?? 'belum_dijemput');

                                                        [$badgeClass, $label] = match ($status) {
                                                            'belum_dijemput' => ['badge-secondary', 'Belum Dijemput'],
                                                            'perjalanan'     => ['badge-info',      'Perjalanan'],
                                                            'tiba_ditujuan'  => ['badge-success',   'Tiba di Tujuan'],
                                                            default          => ['badge-light',     ucfirst(str_replace('_',' ', (string)$status))],
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                                </td>

                                                <td class="d-flex flex-column flex-md-row align-items-start gap-1" style="gap:6px;">
                                                    {{-- Detail --}}
                                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-xs">Detail</a>

                                                    {{-- Cetak --}}
                                                    @can('isAdmin')
                                                        <a href="/print?order={{ $order->order_code }}" target="_blank" class="btn btn-success btn-xs">Cetak</a>
                                                    @else
                                                        @if ($order->transaction->status == true)
                                                            <a href="/print?order={{ $order->order_code }}" target="_blank" class="btn btn-success btn-xs">Cetak</a>
                                                        @endif
                                                    @endcan

                                                    {{-- Hapus/Batal --}}
                                                    @can('isCustomer')
                                                        @if ($order->transaction->status == false)
                                                            <form action="orders/{{ $order->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-xs" type="submit">
                                                                    @can('is_admin') Hapus @else Batal @endcan
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <form action="orders/{{ $order->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-xs" type="submit">
                                                                @can('is_admin') Hapus @else Batal @endcan
                                                            </button>
                                                        </form>
                                                    @endcan

                                                    {{-- Lapor --}}
                                                    <button class="btn btn-warning btn-xs position-relative"
                                                            type="button"
                                                            data-toggle="modal"
                                                            data-target="#modal-lapor-{{ $order->id }}"
                                                            id="button-{{ $order->id }}">
                                                        Lapor
                                                        @can('isCustomer')
                                                            @if ($order->complaints->where('seenForAdmin', 0)->count() != 0)
                                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                  {{ $order->complaints->where('seenForAdmin', 0)->count() }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            @if ($order->complaints->where('seen', 0)->count() != 0)
                                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                  {{ $order->complaints->where('seen', 0)->count() }}
                                                                </span>
                                                            @endif
                                                        @endcan
                                                    </button>

                                                    {{-- ======================= MODAL LAPOR (RESPONSIF) ======================= --}}
                                                    <div class="modal fade" id="modal-lapor-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">
                                                                        Form Pengaduan &middot; <small class="text-muted">Order {{ $order->order_code ?? $order->id }}</small>
                                                                    </h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                {{-- AREA CHAT (SCROLLABLE) --}}
                                                                <div class="modal-body d-flex flex-column chat-scroll" id="chatBody-{{ $order->id }}">
                                                                    @foreach ($order->complaints as $complaint)
                                                                        @php
                                                                            $isMe = $complaint->user->id == Auth::id();
                                                                        @endphp
                                                                        <div class="chat-row {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                                                                            @if (!$isMe)
                                                                                <img src="{{ asset($complaint->user->image) }}" alt="{{ $complaint->user->name }}">
                                                                            @endif
                                                                            <div class="d-flex flex-column {{ $isMe ? 'align-items-end' : 'align-items-start' }}" style="max-width:82%;">
                                                                                <span class="name">{{ $complaint->user->name }}</span>
                                                                                <div class="bubble {{ $isMe ? 'from-me' : 'from-them' }}">
                                                                                    {{ $complaint->body }}
                                                                                </div>
                                                                            </div>
                                                                            @if ($isMe)
                                                                                <img src="{{ asset($complaint->user->image) }}" alt="{{ $complaint->user->name }}" class="ml-2">
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                                {{-- INPUT FORM (STICKY DI BAWAH) --}}
                                                                <form action="/complaints" method="POST">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="modal-body pt-0">
                                                                        <div class="row align-items-center no-gutters" style="gap:8px;">
                                                                            <label class="col-sm-3 col-12 col-form-label mb-1 mb-sm-0">Kirim pesan baru:</label>
                                                                            <div class="col-sm-7 col-12">
                                                                                <input type="text" class="form-control" name="body" required placeholder="Tulis pesan…">
                                                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                                            </div>
                                                                            <div class="col-sm-2 col-12 mt-1 mt-sm-0">
                                                                                <input type="submit" class="btn btn-success btn-block w-100" value="Submit" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- ===================== /MODAL LAPOR ===================== --}}

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
    <strong>
        <a href="https://poliwangi.ac.id/" target="_blank" rel="noopener noreferrer">
            TJ Trans Executive x Poliwangi © <script>document.write(new Date().getFullYear());</script>
        </a>
    </strong> 
    All rights reserved.
</footer>


        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    {{-- =================== STYLE: CHAT LAPOR RESPONSIF =================== --}}
    <style>
        /* container modal lebih pas di layar kecil */
        @media (max-width: 767.98px) {
          .modal-dialog.modal-lg { max-width: 95% !important; margin: 8px auto; }
        }

        /* area chat scrollable */
        .chat-scroll {
          max-height: 58vh;
          overflow-y: auto;
          padding: 8px 10px;
          background: #fafafa;
        }

        /* bubble chat */
        .bubble {
          display: inline-block;
          padding: 8px 12px;
          border-radius: 12px;
          max-width: 82%;
          word-wrap: break-word;
          font-size: 14px;
          line-height: 1.4;
          box-shadow: 0 1px 2px rgba(0,0,0,.06);
        }
        .from-me {
          background: #007bff;
          color: #fff;
          border-bottom-right-radius: 0;
        }
        .from-them {
          background: #f1f0f0;
          color: #222;
          border-bottom-left-radius: 0;
        }

        /* baris chat */
        .chat-row {
          display: flex;
          align-items: flex-end;
          gap: 8px;
          margin-bottom: 10px;
        }
        .chat-row img {
          width: 28px; height: 28px; border-radius: 50%; object-fit: cover;
        }
        .name { font-size: 12px; color: #666; margin: 0 4px 4px 4px; }

        /* input form compact di bawah modal */
        .modal-body input[type="text"] { font-size: 14px; }

        @media (max-width: 576px) {
          .modal-body .row { flex-direction: column; gap: 6px; }
          .modal-body input[type="text"] { width: 100%; margin-bottom: 6px; }
          .modal-body .btn-success { width: 100%; }
        }
    </style>

    {{-- =================== JS: AUTO SCROLL KE PESAN TERBARU =================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-scroll saat modal dibuka
            $('[id^="modal-lapor-"]').on('shown.bs.modal', function () {
                const body = this.querySelector('.chat-scroll');
                if (body) body.scrollTop = body.scrollHeight;
            });
        });
        
    </script>
    
@endsection
