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
      <img src="{{ asset('favicon.ico') }}" alt="TJ Trans Executive Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
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
          <div class="col-sm-6"><h1>Riwayat Transaksi</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Riwayat Transaksi</li>
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

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
              <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                  @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DATA RIWAYAT TRANSAKSI</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID Booking</th>
                      <th>Nama</th>
                      <th>Metode</th>
                      <th>Nama Akun</th>
                      <th>No. Rekening Pelanggan</th>
                      <th>No. Rekening Tujuan</th>
                      <th>Total</th>
                      <th>Bukti Pembayaran</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($transactions as $transaction)
                      @php
                        $order  = $transaction->order;              // bisa null
                        $user   = optional($order)->user;           // bisa null
                        $method = $transaction->method ?? optional($order)->method;
                      @endphp

                      <tr>
                        <td>
                          @if($order)
                            {{ $order->order_code }}
                          @else
                            <span class="text-danger">Order tidak ditemukan</span>
                          @endif
                        </td>

                        <td>{{ optional($user)->name ?? '-' }}</td>
                        <td>{{ optional($method)->method ?? '-' }}</td>
                        <td>{{ $transaction->name_account }}</td>
                        <td>{{ $transaction->from_account }}</td>
                        <td>{{ optional($method)->target_account ?? '-' }}</td>
                        <td>Rp {{ number_format($transaction->total,0,',','.') }}</td>

                        <td>
                          @if($transaction->image)
                            <img style="width:100px;height:60px;object-fit:cover"
                                 src="{{ asset('storage/'.$transaction->image) }}"
                                 alt="{{ optional($order)->order_code ?? 'bukti-pembayaran' }}">
                          @else
                            <span class="badge badge-warning">Belum diunggah</span>
                          @endif
                        </td>

                        <td>
                          @if($transaction->status)
                            <span class="badge badge-success">Disetujui</span>
                          @else
                            <span class="badge badge-secondary">Belum/Tidak disetujui</span>
                          @endif
                        </td>

                        <td>
                          @can('isAdmin')
                            @if($order)
                              <button class="btn btn-primary btn-xs" type="button"
                                      data-toggle="modal"
                                      data-target="#modal-transaction-{{ $transaction->id }}">
                                Perbarui Status
                              </button>
                            @endif
                          @else
                            <button class="btn btn-primary btn-xs" type="button"
                                    data-toggle="modal"
                                    data-target="#modal-upload-{{ $transaction->id }}">
                              Unggah Bukti
                            </button>
                          @endcan
                        </td>
                      </tr>

                      {{-- Modal ADMIN: Update Status (render hanya jika order ada) --}}
                      @can('isAdmin')
                        @if($order)
                          <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                               id="modal-transaction-{{ $transaction->id }}">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">
                                    Update Status Transaksi – <strong>Booking ID {{ $order->order_code }}</strong>
                                  </h4>
                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>

                                <form action="{{ route('transactions.update', $transaction) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">

                                    <div class="card card-body mb-3">
                                      <h5 class="font-weight-bold">Data Penumpang</h5>
                                      @if($order->passengers && $order->passengers->count())
                                        <ol class="mb-0">
                                          @foreach($order->passengers as $passenger)
                                            <li class="mb-3">
                                              <div class="d-flex">
                                                <div style="width:130px;font-weight:700">Nama</div>
                                                <div style="width:20px">:</div>
                                                <div>{{ $passenger->name ?? '-' }}</div>
                                              </div>
                                              <div class="d-flex">
                                                <div style="width:130px;font-weight:700">Umur</div>
                                                <div style="width:20px">:</div>
                                                <div>{{ $passenger->umur_penumpang ?? '-' }}</div>
                                              </div>
                                              <div class="d-flex">
                                                <div style="width:130px;font-weight:700">Jenis Kelamin</div>
                                                <div style="width:20px">:</div>
                                                <div>
                                                  @if(isset($passenger->gender))
                                                    {{ $passenger->gender ? 'Laki-laki' : 'Perempuan' }}
                                                  @else
                                                    -
                                                  @endif
                                                </div>
                                              </div>
                                            </li>
                                          @endforeach
                                        </ol>
                                      @else
                                        <span class="text-muted">Data penumpang tidak tersedia.</span>
                                      @endif
                                    </div>

                                    <div class="card card-body mb-3">
                                      <h5 class="font-weight-bold">Bukti Pembayaran</h5>
                                      @if($transaction->image)
                                        <img style="width:240px;height:120px;object-fit:cover"
                                             src="{{ asset('storage/'.$transaction->image) }}"
                                             alt="{{ $order->order_code }}">
                                      @else
                                        <span class="alert alert-warning mb-0">Bukti pembayaran belum diunggah.</span>
                                      @endif
                                    </div>

                                    <div class="input-group w-100 mt-2">
                                      {{-- selalu kirim 0 meski tidak dicentang --}}
                                      <input type="hidden" name="status" value="0">
                                      <div class="input-group-text">
                                        <input type="checkbox"
                                               id="status-{{ $transaction->id }}"
                                               name="status"
                                               value="1"
                                               {{ $transaction->status ? 'checked' : '' }}>
                                      </div>
                                      <label class="form-control mb-0" for="status-{{ $transaction->id }}">
                                        Konfirmasi/setujui transaksi dengan Booking ID {{ $order->order_code }}?
                                      </label>
                                    </div>

                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        @endif
                      @endcan

                      {{-- Modal USER: Upload bukti pembayaran --}}
                      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                           id="modal-upload-{{ $transaction->id }}">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Unggah Bukti Pembayaran</h4>
                              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>

                            <form action="{{ route('transactions.update', $transaction) }}"
                                  method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">
                                @if($transaction->image)
                                  <div class="form-group row">
                                    <img src="{{ asset('storage/'.$transaction->image) }}"
                                         alt="{{ optional($order)->order_code ?? 'bukti-pembayaran' }}"
                                         style="width:120px;height:120px;object-fit:cover" class="rounded border">
                                  </div>
                                @endif

                                <div class="form-group">
                                  <label for="payment-file-{{ $transaction->id }}" class="form-label">
                                    Unggah foto bukti pembayaran
                                  </label>
                                  <div class="input-group">
                                    <div class="custom-file">
                                      <input type="file"
                                             class="custom-file-input"
                                             id="payment-file-{{ $transaction->id }}"
                                             name="image" accept="image/*">
                                      <label class="custom-file-label" for="payment-file-{{ $transaction->id }}">
                                        Pilih file
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="modal-footer justify-content-between">
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>TJ Trans Executive &copy; 2025.</strong> All rights reserved.
    <div class="float-right d-none d-sm-inline-block"></div>
  </footer>

  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

{{-- (Opsional) JS kecil untuk menampilkan nama file di label custom-file --}}
<script>
document.addEventListener('change', function(e){
  if(e.target && e.target.classList.contains('custom-file-input')){
    const label = e.target.nextElementSibling;
    if(label) label.textContent = e.target.files.length ? e.target.files[0].name : 'Pilih file';
  }
});
</script>
@endsection
