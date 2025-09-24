@extends('layouts.front')

@section('front')
<div class="wrapper">
    <x-front-dashboard-navbar></x-front-dashboard-navbar>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/dashboard" class="brand-link">
            <img src="{{ asset('favicon.ico') }}" alt="TJ Trans Executive Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">TJ Trans Executive</span>
        </a>
        <x-front-sidemenu></x-front-sidemenu>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"><div class="row mb-2">
                <div class="col-sm-6"><h1>Drivers</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Drivers</li>
                    </ol>
                </div>
            </div></div>
        </section>

        <section class="content">
            <div class="container-fluid"><div class="row"><div class="col-12">
                @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Data Seluruh Driver</h3>
                        @can('isAdmin')
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-driver-create">+ Tambah Driver</button>
                        @endcan
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>No. SIM</th>
                                    <th>Foto</th>
                                    @can('isAdmin')<th>Aksi</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->nama_driver ?? '-' }}</td>
                                        <td>{{ $driver->username ?? '-' }}</td>
                                        <td>{{ $driver->email ?? '-' }}</td>
                                        <td>{{ $driver->no_telepon ?? 'Belum di set' }}</td>
                                        <td>{{ $driver->sim ?? '-' }}</td>
                                        <td>
                                            @if ($driver->foto)
                                                <img style="width:100px;height:100px;object-fit:cover" src="{{ asset('storage/'.$driver->foto) }}" alt="{{ $driver->nama_driver }}">
                                            @else Belum di set @endif
                                        </td>

                                        @can('isAdmin')
                                        <td class="d-flex" style="gap:6px;">
                                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-driver-{{ $driver->id }}">Ubah</button>
                                            <form action="{{ route('drivers.destroy',$driver) }}" method="POST" onsubmit="return confirm('Hapus driver ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-xs" type="submit">Hapus</button>
                                            </form>
                                        </td>
                                        @endcan
                                    </tr>

                                    @can('isAdmin')
                                    <!-- Modal Update -->
                                    <div class="modal fade" id="modal-driver-{{ $driver->id }}">
                                        <div class="modal-dialog modal-lg"><div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Ubah Data Driver</h4>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <form action="{{ route('drivers.update',$driver) }}" method="POST" enctype="multipart/form-data">
                                                @csrf @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" name="name" value="{{ old('name', $driver->nama_driver) }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" class="form-control" name="username" value="{{ old('username', $driver->username) }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name="email" value="{{ old('email', $driver->email) }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Telepon</label>
                                                        <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $driver->no_telepon) }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. SIM</label>
                                                        <input type="text" class="form-control" name="sim" value="{{ old('sim', $driver->sim) }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Foto</label><br>
                                                        @if ($driver->foto)
                                                            <img style="max-width:100px;max-height:100px" src="{{ asset('storage/'.$driver->foto) }}" alt="">
                                                        @endif
                                                        <input type="file" class="form-control" name="foto">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password (opsional)</label>
                                                        <input type="text" class="form-control" name="password" placeholder="Kosongkan jika tidak diubah">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit">Simpan</button>
                                                </div>
                                            </form>
                                        </div></div>
                                    </div>
                                    @endcan
                                @empty
                                    <tr><td colspan="7" class="text-center">Belum ada data driver.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @can('isAdmin')
                <!-- Modal Create -->
                <div class="modal fade" id="modal-driver-create">
                    <div class="modal-dialog modal-lg"><div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Driver</h4>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group"><label>Nama</label><input name="name" class="form-control" required></div>
                                <div class="form-group"><label>Username</label><input name="username" class="form-control" required></div>
                                <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                                <div class="form-group"><label>Password (opsional)</label><input type="text" name="password" class="form-control" placeholder="Jika kosong, dibuat otomatis"></div>
                                <div class="form-group"><label>No. Telepon</label><input name="phone_number" class="form-control"></div>
                                <div class="form-group"><label>No. SIM</label><input name="sim" class="form-control"></div>
                                <div class="form-group"><label>Foto</label><input type="file" name="foto" class="form-control"></div>
                            </div>
                            <div class="modal-footer"><button class="btn btn-success" type="submit">Simpan</button></div>
                        </form>
                    </div></div>
                </div>
                @endcan

            </div></div></div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>TJ Trans Executive &copy; 2025.</strong> All rights reserved.
    </footer>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
@endsection
