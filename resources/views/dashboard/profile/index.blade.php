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
                class="brand-image img-circle elevation-3" style="opacity: .8">            
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
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (session('sameTicket'))
                        <div class="alert alert-danger">
                            {{ session('sameTicket') }}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-primary @can('isAdmin') card-danger @endcan card-outline">
                            <div class="card-header box-profile d-flex flex-column align-items-center">
                                <div class="text-center">
                                    @if($user->image && file_exists(public_path($user->image)))
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset($user->image) }}" alt="User Image">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/default.png') }}" alt="Default profile picture">
                                    @endif
                                </div>

                                <h3 class="mt-3 profile-username text-center">{{ $user->name }}</h3>

                                <h6 class="mt-3 text-center bg-primary @can('isAdmin') bg-danger @endcan rounded w-50 h-100">
                                    {{ $user->role }}
                                </h6>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-body">
                                <p class="text-muted text-center">{{ $user->email }}</p>

                                <p class="text-muted text-center">
                                    @if ($user->email_verified_at)
                                        Email telah terverifikasi <span style="color: green; font-size: 20px">&#10003;</span>
                                    @else
                                        Email belum terverifikasi <span style="color: red; font-size: 20px">&#10540;</span>
                                    @endif
                                </p>

                                <p class="text-muted text-center">
                                    @if ($user->phone_number)
                                        {{ $user->phone_number }} &#128383;
                                    @else
                                        Nomor telepon belum di set
                                    @endif
                                </p>

                                <p class="text-muted text-center">
                                    @if ($user->gender !== null)
                                        @if ($user->gender == 1)
                                            Laki-laki
                                        @elseif($user->gender == 0)
                                            Perempuan
                                        @endif
                                    @else
                                        Jenis kelamin belum di set
                                    @endif
                                </p>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-12 d-flex justify-content-center">
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="button" class="btn btn-danger w-100" id="logout-button">Logout</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="settings">
                                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-2 col-form-label">Nama:</label>
                                                    <input type="text" class="form-control col-sm-10" value="{{ old('name', $user->name) }}" name="name" required>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="email" class="col-sm-2 col-form-label">Email:</label>
                                                    <input type="email" class="form-control col-sm-10" value="{{ old('email', $user->email) }}" disabled>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="phone_number" class="col-sm-2 col-form-label">Nomor Telepon:</label>
                                                    <input type="text" class="form-control col-sm-10" value="{{ old('phone_number', $user->phone_number) }}" placeholder="silakan ketikkan nomor telepon anda" name="phone_number" required>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="gender" class="col-sm-2 col-form-label">Jenis:</label>
                                                    <div class="col-sm-10">
                                                        <select name="gender" id="gender" class="form-control" required>
                                                            @if ($user->gender !== null)
                                                                <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value='0' {{ $user->gender == '0' ? 'selected' : '' }}>Perempuan</option>
                                                            @else
                                                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                                <option value="1">Laki-laki</option>
                                                                <option value="0">Perempuan</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label for="image" class="col-sm-2 col-form-label">Foto Profil:</label>
                                                    <div class="col-sm-10">
                                                        @if ($user->image)
                                                            <div class="d-flex align-items-center">
                                                                <img style="max-width: 100px" src="{{ asset($user->image) }}" alt="User Image">
                                                                <button type="button" id="deleteProfileImage" class="btn btn-danger ml-2">Hapus Gambar</button>
                                                            </div>
                                                        @endif
                                                        <input type="file" class="form-control mt-2" name="image" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-success" />
                                            </div>
                                        </form>

                                        <form id="deleteProfileImageForm" action="{{ route('user.deleteImage') }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        </form>
                                        
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>TJ Trans Executive &copy; 2025.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('deleteProfileImage').addEventListener('click', function() {
        Swal.fire({
            title: "Anda yakin ingin menghapus foto profil?",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteProfileImageForm').submit();
            }
        });
    });
</script>

<script>
    document.getElementById('logout-button').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Apakah Anda yakin ingin keluar?",
            showCancelButton: true,
            confirmButtonText: "Ya, keluar",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
@endsection