@php
    function active($pattern) { return request()->is($pattern) ? 'active' : ''; }

    $user = Auth::user();
    $hasImage = $user && $user->image && file_exists(public_path($user->image));
    $avatar = $hasImage ? asset($user->image) : asset('images/default.png');
@endphp

<style>
/* Warna elegan biru gelap tanpa ganggu efek bawaan AdminLTE */
.main-sidebar.sidebar-dark-primary {
    background: linear-gradient(180deg, #0e2f57 0%, #103e74 60%, #0b2847 100%) !important;
}
.main-sidebar .brand-link {
    background: rgba(255, 255, 255, 0.05);
    color: #e6f0fa !important;
}
.main-sidebar .brand-link:hover {
    background: rgba(255, 255, 255, 0.1);
}
.nav-sidebar > .nav-item > .nav-link.active {
    background-color: #1565c0 !important;
    color: #fff !important;
}
.nav-sidebar > .nav-item > .nav-link:hover {
    background-color: #1e88e5 !important;
    color: #fff !important;
}
.nav-header {
    color: #9fbbe7 !important;
}
.user-panel .info a {
    color: #fff !important;
    font-weight: 600;
}
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-2">
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('favicon.ico') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.9">
        <span class="brand-text font-weight-light">TJ Trans Executive</span>
    </a>

    <div class="sidebar">
        <div class="user-panel d-flex align-items-center mt-3 pb-3 mb-3">
            <div class="image me-2">
                <a href="{{ url('/users/' . Auth::id()) }}" class="d-block">
                    <img src="{{ $avatar }}" class="img-circle elevation-2" width="50" height="50" alt="{{ $user->name }}">
                </a>
            </div>
            <div class="info">
                <a href="{{ url('/users/' . Auth::id()) }}" class="d-block">{{ $user->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ active('/') }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Halaman Utama</p>
                    </a>
                </li>

                <li class="nav-header">MENUS</li>

                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ active('dashboard*') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/tickets') }}" class="nav-link {{ active('tickets*') }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Daftar Tiket</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/orders/create') }}" class="nav-link {{ active('orders/create') }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Buat Pesanan</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('orders') || request()->is('transactions') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('orders') || request()->is('transactions') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-ul"></i>
                        <p>Riwayat <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/orders') }}" class="nav-link {{ active('orders') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pesanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transactions') }}" class="nav-link {{ active('transactions') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @can('isAdmin')
                    <li class="nav-item">
                        <a href="{{ url('/users') }}" class="nav-link {{ active('users*') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/trains') }}" class="nav-link {{ active('trains*') }}">
                            <i class="nav-icon fas fa-bus"></i>
                            <p>Armada</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/tracks') }}" class="nav-link {{ active('tracks*') }}">
                            <i class="nav-icon fas fa-route"></i>
                            <p>Rute Berangkat</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/methods') }}" class="nav-link {{ active('methods*') }}">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Metode Pembayaran</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/finance') }}" class="nav-link {{ active('finance*') }}">
                            <i class="nav-icon fas fa-coins"></i>
                            <p>Keuangan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('drivers.index') }}" class="nav-link {{ active('drivers*') }}">
                            <i class="nav-icon fas fa-id-badge"></i>
                            <p>Driver</p>
                        </a>
                    </li>
                @endcan

            </ul>
        </nav>
    </div>
</aside>
