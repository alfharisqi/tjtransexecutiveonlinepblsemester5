@extends('layouts.front')

@section('front')
    <div class="wrapper">
        <!-- Navbar -->
        <x-front-dashboard-navbar></x-front-dashboard-navbar>
        <!-- /.Navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/dashboard" class="brand-link">
                <img src="{{ asset('favicon.ico') }}" alt="TJ Trans Executive Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">TJ Trans Executive</span>
            </a>
            <x-front-sidemenu></x-front-sidemenu>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1>Metode Pembayaran</h1></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Metode Pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row"><div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                @if (session('update')) <div class="alert alert-success">{{ session('update') }}</div> @endif
                                @if (session('delete')) <div class="alert alert-success">{{ session('delete') }}</div> @endif
                                @if (session('store')) <div class="alert alert-success">{{ session('store') }}</div> @endif
                                @if (session('sameMethod')) <div class="alert alert-danger">{{ session('sameMethod') }}</div> @endif

                                <div class="row mb-2">
                                    <div class="col-sm-6"><h3 class="card-title">Data Metode Pembayaran</h3></div>
                                    @can('isAdmin')
                                    <div class="col-sm-6">
                                        <button class="btn btn-warning btn-sm float-sm-right" type="button"
                                            data-toggle="modal" data-target="#modal-tambah-type">
                                            Tambah Metode Pembayaran
                                        </button>

                                        <!-- Modal Tambah -->
                                        <div class="modal fade" id="modal-tambah-type">
                                            <div class="modal-dialog modal-lg"><div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Form Tambah Metode Pembayaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <form action="/methods" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                                                            <input type="text" class="col-sm-8 form-control"
                                                                name="method" placeholder="Masukkan Metode Pembayaran">
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Nomor Rekening Tujuan</label>
                                                            <input type="text" class="col-sm-8 form-control"
                                                                name="target_account" placeholder="Masukkan Nomor Rekening Tujuan">
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Foto Metode</label>
                                                            <input type="file" class="col-sm-8 form-control"
                                                                name="foto_method" accept="image/*">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-success" />
                                                    </div>
                                                </form>
                                            </div></div>
                                        </div>
                                    </div>
                                    @endcan
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Rekening Tujuan</th>
                                            <th>Foto</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($methods as $method)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $method->id }}</td>
                                            <td>{{ $method->method }}</td>
                                            <td>{{ $method->target_account }}</td>
                                            <td>
                                                @if($method->foto_method)
                                                    <img src="{{ asset('storage/'.$method->foto_method) }}"
                                                         style="max-width:80px; max-height:80px; object-fit:cover"
                                                         alt="Foto {{ $method->method }}">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class='btn btn-primary btn-xs mx-1' data-toggle="modal"
                                                    data-target="#modal-ubah-{{ $method->id }}">Ubah</a>
                                                <form action="/methods/{{ $method->id }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus?');"
                                                    style="display:inline-block;">
                                                    @csrf @method('DELETE')
                                                    <button class='btn btn-danger btn-xs mx-1'>Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Ubah -->
                                        <div class="modal fade" id="modal-ubah-{{ $method->id }}">
                                            <div class="modal-dialog modal-lg"><div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Form Ubah Metode Pembayaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <form action="/methods/{{ $method->id }}" method="POST" enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                                                            <input type="text" class="col-sm-8 form-control"
                                                                value="{{ old('method', $method->method) }}" disabled>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Nomor Rekening Tujuan</label>
                                                            <input type="text" class="col-sm-8 form-control"
                                                                name="target_account"
                                                                value="{{ old('target_account', $method->target_account) }}">
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Foto Metode</label>
                                                            <div class="col-sm-8">
                                                                @if($method->foto_method)
                                                                    <img src="{{ asset('storage/'.$method->foto_method) }}"
                                                                         style="max-width:100px;max-height:100px;object-fit:cover"
                                                                         class="mb-2">
                                                                @endif
                                                                <input type="file" class="form-control"
                                                                    name="foto_method" accept="image/*">
                                                                <small class="text-muted">Kosongkan jika tidak diubah</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-success" />
                                                    </div>
                                                </form>
                                            </div></div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div></div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>TJ Trans Executive &copy; 2025.</strong> All rights reserved.
        </footer>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
@endsection
