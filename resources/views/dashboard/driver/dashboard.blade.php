@extends('layouts.front')

@section('front')
<div class="wrapper">
    <div class="content-wrapper">
        {{-- ====== STYLE KHUSUS DASHBOARD DRIVER ====== --}}
        <style>
            /* Hilangkan ruang kosong kiri (efek sidebar-mini) */
            body.sidebar-mini .content-wrapper,
            body.sidebar-mini .main-footer,
            body.sidebar-mini .main-header {
                margin-left: 0 !important;
            }

            .driver-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: .5rem;
            }
            .driver-header-title h1 {
                margin-bottom: .25rem;
            }
            .driver-header-actions .btn {
                min-width: 110px;
            }

            .driver-photo-box {
                max-width: 220px;
                height: 220px;
                border-radius: 12px;
                overflow: hidden;
                background: #f5f5f5;
            }
            .driver-photo-box img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .driver-card {
                border-radius: 10px;
            }

            .driver-card .card-header {
                border-radius: 10px 10px 0 0;
            }

            .driver-table th,
            .driver-table td {
                vertical-align: middle !important;
            }

            .status-badge {
                font-size: 12px;
                padding: .25rem .6rem;
                border-radius: 999px;
            }

            .btn-status-group .btn {
                white-space: nowrap;
            }

            /* ====== RESPONSIVE ====== */
            @media (max-width: 767.98px) {
                .driver-header {
                    align-items: flex-start;
                }
                .driver-header-actions {
                    width: 100%;
                    text-align: left;
                }
                .driver-header-actions .btn {
                    width: 100%;
                }
                .driver-photo-box {
                    margin: 0 auto .75rem auto;
                    max-width: 180px;
                    height: 180px;
                }
                .driver-table-wrapper {
                    border-radius: 8px;
                    border: 1px solid #e5e7eb;
                    padding: .5rem;
                    background: #fff;
                }
                .driver-table {
                    font-size: 13px;
                }
                .driver-table th:nth-child(1),
                .driver-table td:nth-child(1) {
                    width: 40px;
                }
                .driver-table td {
                    white-space: nowrap;
                }
                .btn-status-group {
                    display: flex;
                    flex-direction: column;
                    gap: .25rem;
                }
                .btn-status-group .btn {
                    width: 100%;
                }
            }

            @media (max-width: 575.98px) {
                .driver-table thead {
                    font-size: 12px;
                }
                .modal-dialog {
                    max-width: 100%;
                    margin: .5rem;
                }
                .modal-body {
                    padding: .75rem;
                }
            }
        </style>

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="driver-header">
                    <div class="driver-header-title">
                        <h1>Dashboard Driver</h1>
                        <p class="text-muted mb-0">
                            Selamat datang, {{ auth('driver')->user()->nama_driver }} 🎉
                        </p>
                    </div>

                    @auth('driver')
                        <div class="driver-header-actions">
                            <form id="driver-logout-form" action="{{ route('driver.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <button
                                type="button"
                                class="btn btn-outline-danger"
                                onclick="event.preventDefault(); document.getElementById('driver-logout-form').submit();">
                                Logout
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                {{-- ========== 1) Identitas Driver ========== --}}
                @php $driver = auth('driver')->user(); @endphp

                <div class="card card-outline card-success driver-card mb-3">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Identitas Driver</h3>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                @php $fotoPath = $driver->foto ?? null; @endphp
                                @if ($fotoPath)
                                    <div class="driver-photo-box shadow-sm">
                                        <img src="{{ asset('storage/'.$fotoPath) }}"
                                             alt="Foto {{ $driver->nama_driver }}">
                                    </div>
                                @else
                                    <div class="driver-photo-box d-flex align-items-center justify-content-center border">
                                        <span class="text-muted">Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width:200px;">Nama Driver</th>
                                                <td>{{ $driver->nama_driver ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $driver->email ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>No. Telepon</th>
                                                <td>{{ $driver->no_telepon ?? $driver->telepon ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>SIM</th>
                                                <td>{{ $driver->sim ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td><span class="badge badge-success status-badge">Aktif</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== 2) (Opsional) Jadwal Driver (Upcoming) ========== --}}
                @php
                    $driverTickets = $driverTickets ?? collect();
                    $nowWIB = \Carbon\Carbon::now('Asia/Jakarta');
                    $upcoming = $driverTickets->filter(function($t) use ($nowWIB) {
                        return optional($t->departure_at)->gt($nowWIB->copy()->utc());
                    });
                @endphp
                {{-- (bila nanti mau ditampilkan, tinggal aktifkan section khusus upcoming) --}}

                {{-- ========== 3) Daftar Tiket Driver ========== --}}
                <div class="card card-outline card-warning driver-card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Tiket Saya</h3>
                    </div>
                    <div class="card-body">
                        @if ($driverTickets->isEmpty())
                            <p class="text-muted mb-0">Belum ada tiket terkait driver ini.</p>
                        @else
                            <div class="driver-table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped driver-table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width:40px;">#</th>
                                                <th>Armada / Kelas</th>
                                                <th>Rute</th>
                                                <th>Berangkat</th>
                                                <th>Tiba</th>
                                                <th>Harga</th>
                                                <th style="width:110px;">Penumpang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($driverTickets as $idx => $t)
                                                @php
                                                    $modalId = 'penumpangModal_'.$t->id;
                                                    $orders = $t->orders ?? collect();
                                                    $totalPassengers = $orders->reduce(function($carry, $o){
                                                        if ($o->passengers && $o->passengers->count()) {
                                                            return $carry + $o->passengers->count();
                                                        }
                                                        $fallbackQty = $o->qty ?? $o->jumlah ?? $o->seats ?? 0;
                                                        return $carry + (int)$fallbackQty;
                                                    }, 0);
                                                @endphp
                                                <tr>
                                                    <td>{{ $idx+1 }}</td>
                                                    <td>
                                                        <div class="font-weight-bold">{{ $t->train->name ?? '-' }}</div>
                                                        <small class="text-muted">{{ $t->train->class ?? '-' }}</small>
                                                    </td>
                                                    <td>
                                                        {{ ($t->track->from_route ?? '-') . ' → ' . ($t->track->to_route ?? '-') }}
                                                    </td>
                                                    <td>
                                                        {{ $t->departure_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                                                    </td>
                                                    <td>
                                                        {{ $t->arrival_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                                                    </td>
                                                    <td>
                                                        {{ optional($t->price)->price ? 'Rp '.number_format($t->price->price,0,',','.') : '-' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#{{ $modalId }}">
                                                            Lihat ({{ $totalPassengers }})
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ===== MODAL PENUMPANG ===== --}}
                            @foreach ($driverTickets as $t)
                                @php
                                    $modalId = 'penumpangModal_'.$t->id;
                                    $orders = $t->orders ?? collect();
                                @endphp

                                <div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="{{ $modalId }}Label">
                                                    Penumpang — Tiket #{{ $t->id }}
                                                    | {{ ($t->track->from_route ?? '-') . ' → ' . ($t->track->to_route ?? '-') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                @if(($orders ?? collect())->isEmpty())
                                                    <p class="text-muted mb-0">Belum ada pemesanan pada tiket ini.</p>
                                                @else
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm mb-0">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th style="width:40px;">#</th>
                                                                    <th>ID Order</th>
                                                                    <th>Pemesan</th>
                                                                    <th>Penumpang</th>
                                                                    <th>No. Seat</th>
                                                                    <th>Titik Jemput</th>
                                                                    <th>No. WhatsApp</th>
                                                                    <th>Status Perjalanan</th>
                                                                    <th style="min-width:180px;">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($orders as $k => $o)
                                                                    @php
                                                                        $pemesan = optional($o->user)->name ?? optional($o->user)->username ?? '—';
                                                                        $pickup  = $o->pickup_point ?? $o->pickup_location ?? $o->alamat_lengkap ?? '—';
                                                                        $passengerList = $o->passengers?->pluck('name')->filter()->implode(', ') ?? '—';
                                                                        $wa = $o->nowhatsapp ?? $o->no_whatsapp ?? $o->phone ?? '—';

                                                                        $seatList = '—';
                                                                        if (!empty($o->selected_seats)) {
                                                                            $decoded = json_decode($o->selected_seats, true);
                                                                            $seatList = is_array($decoded)
                                                                                ? collect($decoded)->implode(', ')
                                                                                : collect(explode(',', $o->selected_seats))
                                                                                    ->map(fn($s) => trim($s))
                                                                                    ->filter()
                                                                                    ->implode(', ');
                                                                        }

                                                                        $statusRow  = $o->statusPerjalanan; // relasi ke tabel status_perjalanan
                                                                        $status     = $statusRow?->status ?? 'belum_dijemput';
                                                                        $badgeClass = $statusRow?->badge ?? match($status) {
                                                                            'belum_dijemput' => 'badge-secondary',
                                                                            'perjalanan'     => 'badge-info',
                                                                            'tiba_ditujuan'  => 'badge-success',
                                                                            default          => 'badge-light',
                                                                        };
                                                                        $label = $statusRow?->label ?? ucfirst(str_replace('_',' ', $status));
                                                                    @endphp

                                                                    <tr>
                                                                        <td>{{ $k+1 }}</td>
                                                                        <td>{{ $o->id }}</td>
                                                                        <td>{{ $pemesan }}</td>
                                                                        <td>{{ $passengerList }}</td>
                                                                        <td>{{ $seatList }}</td>
                                                                        <td>{{ $pickup }}</td>
                                                                        <td>{{ $wa }}</td>
                                                                        <td>
                                                                            <span class="badge {{ $badgeClass }} status-badge">
                                                                                {{ $label }}
                                                                            </span>
                                                                        </td>

                                                                        <td>
                                                                            <div class="btn-group btn-group-sm btn-status-group" role="group" aria-label="Status perjalanan">
                                                                                {{-- Belum Dijemput --}}
                                                                                <form action="{{ route('driver.status-perjalanan.update', $o->id) }}" method="POST" class="mr-1 mb-1 mb-md-0">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                    <input type="hidden" name="next_status" value="belum_dijemput">
                                                                                    <button type="submit"
                                                                                        class="btn {{ $status==='belum_dijemput' ? 'btn-secondary active' : 'btn-outline-secondary' }}">
                                                                                        Belum dijemput
                                                                                    </button>
                                                                                </form>

                                                                                {{-- Perjalanan --}}
                                                                                <form action="{{ route('driver.status-perjalanan.update', $o->id) }}" method="POST" class="mr-1 mb-1 mb-md-0">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                    <input type="hidden" name="next_status" value="perjalanan">
                                                                                    <button type="submit"
                                                                                        class="btn {{ $status==='perjalanan' ? 'btn-info active' : 'btn-outline-info' }}">
                                                                                        Perjalanan
                                                                                    </button>
                                                                                </form>

                                                                                {{-- Tiba di Tujuan --}}
                                                                                <form action="{{ route('driver.status-perjalanan.update', $o->id) }}" method="POST">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                    <input type="hidden" name="next_status" value="tiba_ditujuan">
                                                                                    <button type="submit"
                                                                                        class="btn {{ $status==='tiba_ditujuan' ? 'btn-success active' : 'btn-outline-success' }}">
                                                                                        Tiba di tujuan
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- ===== /MODAL ===== --}}
                        @endif
                    </div>
                </div>

            </div> {{-- /.container-fluid --}}
        </section>
    </div> {{-- /.content-wrapper --}}
</div> {{-- /.wrapper --}}
@endsection
