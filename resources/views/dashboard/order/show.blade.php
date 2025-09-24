@extends('layouts.front')

@section('front')
<div class="wrapper">
  {{-- Navbar --}}
  <x-front-dashboard-navbar></x-front-dashboard-navbar>

  {{-- Sidebar --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/dashboard" class="brand-link">
      <img src="{{ asset('favicon.ico') }}" class="brand-image img-circle elevation-3" style="opacity:.8" alt="Sonic">
      <span class="brand-text font-weight-light">Sonic</span>
    </a>
    <x-front-sidemenu></x-front-sidemenu>
  </aside>

  {{-- Content --}}
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1>Detail Pesanan</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
              <li class="breadcrumb-item active">Detail</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
          <div class="col-lg-7">
            <div class="card">
              <div class="card-header"><h3 class="card-title">Informasi Pesanan</h3></div>
              <div class="card-body">
                <dl class="row mb-0">
                  <dt class="col-sm-4">Kode Pesanan</dt>
                  <dd class="col-sm-8">{{ $order->order_code ?? $order->code }}</dd>

                  <dt class="col-sm-4">Pemesan</dt>
                  <dd class="col-sm-8">{{ $order->user->name ?? '-' }}</dd>

                  <dt class="col-sm-4">No. WhatsApp</dt>
                  <dd class="col-sm-8">{{ $order->nowhatsapp ?? '-' }}</dd>

                  <dt class="col-sm-4">Alamat Penjemputan</dt>
                  <dd class="col-sm-8">{{ $order->alamat_lengkap ?? '-' }}</dd>

                  <dt class="col-sm-4">Rute</dt>
                  <dd class="col-sm-8">
                    {{ optional($order->ticket->track)->from_route }} → {{ optional($order->ticket->track)->to_route }}
                  </dd>

                  <dt class="col-sm-4">Armada / Kelas</dt>
                  <dd class="col-sm-8">
                    {{ optional($order->ticket->train)->name ?? '-' }}
                    ({{ optional($order->ticket->train)->class ?? '-' }})
                  </dd>

                  <dt class="col-sm-4">Berangkat</dt>
                  <dd class="col-sm-8">
                    {{
                      optional($order->ticket->departure_at)?->timezone('Asia/Jakarta')?->format('d M Y H:i')
                      ?? ($order->go_date ?? '-')
                    }}
                  </dd>

                  <dt class="col-sm-4">Tiba</dt>
                  <dd class="col-sm-8">
                    {{
                      optional($order->ticket->arrival_at)?->timezone('Asia/Jakarta')?->format('d M Y H:i')
                      ?? '-'
                    }}
                  </dd>

                  <dt class="col-sm-4">Kursi</dt>
                  <dd class="col-sm-8">{{ $order->selected_seats ?? '-' }}</dd>

                  <dt class="col-sm-4">Jumlah Penumpang</dt>
                  <dd class="col-sm-8">{{ $order->amount ?? '-' }}</dd>

                  <dt class="col-sm-4">Total</dt>
                  <dd class="col-sm-8">
                    Rp {{ number_format(optional($order->transaction)->total ?? 0, 0, ',', '.') }}
                  </dd>

                  <dt class="col-sm-4">Status Pembayaran</dt>
                  <dd class="col-sm-8">
                    @if(optional($order->transaction)->status)
                      <span class="badge badge-success">Disetujui</span>
                    @else
                      <span class="badge badge-secondary">Belum/Tidak disetujui</span>
                    @endif
                  </dd>
                </dl>
              </div>
              <div class="card-footer d-flex gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                <a href="{{ route('transactions.index') }}" class="btn btn-primary">Riwayat Transaksi</a>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="card">
              <div class="card-header"><h3 class="card-title">Penumpang</h3></div>
              <div class="card-body">
                @if($order->passengers && $order->passengers->count())
                  <ol class="mb-0">
                    @foreach($order->passengers as $p)
                      <li class="mb-2">
                        <div><strong>Nama:</strong> {{ $p->name ?? '-' }}</div>
                        <div><strong>Jenis Kelamin:</strong>
                          @if(isset($p->gender))
                            {{ $p->gender ? 'Laki-laki' : 'Perempuan' }}
                          @else
                            -
                          @endif
                        </div>
                        <div><strong>Umur:</strong> {{ $p->umur_penumpang ?? '-' }}</div>

                      </li>
                    @endforeach
                  </ol>
                @else
                  <span class="text-muted">Data penumpang tidak tersedia.</span>
                @endif
              </div>
            </div>

            <div class="card">
              <div class="card-header"><h3 class="card-title">Bukti Pembayaran</h3></div>
              <div class="card-body">
                @if(optional($order->transaction)->image)
                  <img src="{{ asset('storage/'. $order->transaction->image) }}"
                       alt="{{ $order->order_code ?? 'bukti-pembayaran' }}"
                       style="width:100%;max-height:240px;object-fit:cover">
                @else
                  <span class="text-muted">Belum diunggah.</span>
                @endif
              </div>
            </div>

          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>Sonic &copy; 2024.</strong> All rights reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
@endsection
