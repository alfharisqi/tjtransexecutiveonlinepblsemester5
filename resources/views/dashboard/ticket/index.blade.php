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
            <img src="{{ asset('favicon.ico') }}" alt="Sonic Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Sonic</span>
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
                        <h1>Harga</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Harga</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('sameTicket'))
                                    <div class="alert alert-danger">{{ session('sameTicket') }}</div>
                                @endif
                                @if (session('delete'))
                                    <div class="alert alert-success">{{ session('delete') }}</div>
                                @endif
                                @if (session('update'))
                                    <div class="alert alert-success">{{ session('update') }}</div>
                                @endif

                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h3 class="card-title">Data Harga Tiket</h3>
                                    </div>

                                    @can('isAdmin')
                                    <div class="col-sm-6">
                                        <button class="btn btn-warning btn-sm float-sm-right" type="button"
                                                data-toggle="modal" data-target="#modal-lgharga" id="button-tambah-harga">
                                            Tambah Tiket
                                        </button>

                                        <!-- Modal Tambah Tiket -->
                                        <div class="modal fade" id="modal-lgharga">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Form Tambah Tiket</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="/tickets" method="POST">
                                                        @csrf
                                                        @method('POST')

                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <label for="train_id" class="col-sm-3 col-form-label">Armada</label>
                                                                <div class="col-sm-9">
                                                                    <select name="train_id" id="train_id" class="form-control" required>
                                                                        <option selected value="" disabled>Pilih Kereta & Kelas</option>
                                                                        @foreach ($trains as $train)
                                                                            <option value="{{ $train->id }}" @selected(old('train_id') == $train->id)>
                                                                                {{ $train->name }} - {{ $train->class }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('train_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="track_id" class="col-sm-3 col-form-label">Rute</label>
                                                                <div class="col-sm-9">
                                                                    <select name="track_id" id="track_id" class="form-control" onchange="getSelectValue && getSelectValue(this.value);" required>
                                                                        <option selected value="" disabled>Pilih Rute</option>
                                                                        @foreach ($tracks as $track)
                                                                            <option value="{{ $track->id }}" @selected(old('track_id') == $track->id)>
                                                                                {{ $track->from_route }} - {{ $track->to_route }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('track_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>

                                                            {{-- ====== Waktu Berangkat (Tanggal + Jam) ====== --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Tanggal Berangkat</label>
                                                                <div class="col-sm-9">
                                                                    <input type="date" name="departure_date" class="form-control" value="{{ old('departure_date') }}" required>
                                                                    @error('departure_date') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Jam Berangkat</label>
                                                                <div class="col-sm-9">
                                                                    <input type="time" name="departure_time" class="form-control" step="60" value="{{ old('departure_time') }}" required>
                                                                    @error('departure_time') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>

                                                            {{-- ====== Waktu Tiba (Tanggal + Jam) ====== --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Tanggal Tiba</label>
                                                                <div class="col-sm-9">
                                                                    <input type="date" name="arrival_date" class="form-control" value="{{ old('arrival_date') }}" required>
                                                                    @error('arrival_date') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Jam Tiba</label>
                                                                <div class="col-sm-9">
                                                                    <input type="time" name="arrival_time" class="form-control" step="60" value="{{ old('arrival_time') }}" required>
                                                                    @error('arrival_time') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>

                                                            {{-- ====== Harga ====== --}}
                                                            <div class="form-group row">
                                                                <label for="hargaadd" class="col-sm-3 col-form-label">Harga</label>
                                                                <div class="col-sm-9">
                                                                    <input type="number" class="form-control" placeholder="Harga Baru" name="price" id="hargaadd" min="0" value="{{ old('price') }}" required>
                                                                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>

                                                            {{-- ====== Driver (BARU) ====== --}}
                                                            <div class="form-group row">
                                                                <label for="driver_id" class="col-sm-3 col-form-label">Driver</label>
                                                                <div class="col-sm-9">
                                                                    <select name="driver_id" id="driver_id" class="form-control" required>
                                                                        <option selected value="" disabled>Pilih Driver</option>
                                                                        @foreach ($drivers as $driver)
                                                                            <option value="{{ $driver->id }}" @selected(old('driver_id') == $driver->id)>
                                                                                {{ $driver->nama_driver }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('driver_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>

                                                            @if (session('sameTicket'))
                                                                <div class="alert alert-danger">{{ session('sameTicket') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Modal Tambah Tiket -->
                                    </div>
                                    @endcan
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kereta</th>
                                            <th>Kelas</th>
                                            <th>Pergi dari</th>
                                            <th>Tujuan ke</th>
                                            <th>Berangkat (WIB)</th>
                                            <th>Tiba (WIB)</th>
                                            <th>Driver</th> {{-- BARU --}}
                                            <th>Jumlah Harga</th>
                                            @can('isAdmin')
                                                <th>Action</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->train->name ?? 'Tidak dapat ditampilkan' }}</td>
                                                <td>{{ $ticket->train->class ?? 'Tidak dapat ditampilkan' }}</td>
                                                <td>{{ $ticket->track->from_route ?? 'Tidak dapat ditampilkan' }}</td>
                                                <td>{{ $ticket->track->to_route ?? 'Tidak dapat ditampilkan' }}</td>

                                                {{-- Tampilkan datetime baru (departure_at/arrival_at) dalam WIB --}}
                                                <td>
                                                    @if ($ticket->departure_at)
                                                        {{ $ticket->departure_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ticket->arrival_at)
                                                        {{ $ticket->arrival_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                    @else
                                                        Tidak dapat ditampilkan
                                                    @endif
                                                </td>

                                                {{-- Driver (BARU) --}}
                                                <td>
                                                    {{ optional($ticket->driver)->nama_driver ?? 'Belum ditetapkan' }}
                                                </td>

                                                <td>
                                                    @isset($ticket->price->price)
                                                        Rp {{ number_format($ticket->price->price, 0, ',', '.') }}
                                                    @else
                                                        Belum di set
                                                    @endisset
                                                </td>

                                                @can('isAdmin')
                                                <td>
                                                    <a class='btn btn-primary btn-xs mx-1' data-toggle="modal" data-target="#modal-{{ $ticket->id }}">Ubah Harga</a>
                                                    <form action="/tickets/{{ $ticket->id }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class='btn btn-danger btn-xs mx-1'>Delete</button>
                                                    </form>
                                                </td>
                                                @endcan
                                            </tr>

                                            <!-- Modal Ubah Harga -->
                                            <div class="modal fade" id="modal-{{ $ticket->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Form Ubah Harga</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            {{-- Form khusus ubah harga (biarkan sesuai route prices) --}}
                                                            <form action="/prices/{{ $ticket->price ? $ticket->price->id : '' }}" method="POST" class="mb-3">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Harga Lama</label>
                                                                    <div class="col-sm-9 col-form-label">
                                                                        {{ $ticket->price->price ?? 'Not Set Yet' }}
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Harga Baru</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="number" class="form-control" placeholder="Harga Baru" name="price" required>
                                                                    </div>
                                                                </div>

                                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                            </form>

                                                            {{-- (Opsional) Form kecil untuk ubah Driver pakai route tickets.update (hapus bila belum ada routenya) --}}
                                                            {{-- 
                                                            <form action="/tickets/{{ $ticket->id }}" method="POST">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="form-group row">
                                                                    <label for="driver_id_{{ $ticket->id }}" class="col-sm-3 col-form-label">Ubah Driver</label>
                                                                    <div class="col-sm-9">
                                                                        <select name="driver_id" id="driver_id_{{ $ticket->id }}" class="form-control" required>
                                                                            <option value="" disabled>Pilih Driver</option>
                                                                            @foreach ($drivers as $driver)
                                                                                <option value="{{ $driver->id }}" @selected(optional($ticket->driver)->id == $driver->id)>
                                                                                    {{ $driver->nama_driver }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Update Driver</button>
                                                            </form>
                                                            --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Modal Ubah Harga -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Sonic &copy; 2024.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block"></div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>
    <!-- /.control-sidebar -->
</div>
@endsection
