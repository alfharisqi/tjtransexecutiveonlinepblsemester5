@extends('layouts.front')

@section('front')
<div class="wrapper">
    <div class="content-wrapper">
        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <h1>Dashboard Driver</h1>
                <p class="text-muted mb-0">
                    Selamat datang, {{ auth('driver')->user()->nama_driver }} 🎉
                </p>
                {{-- Logout driver (POST) --}}
      @auth('driver')
        <form id="driver-logout-form" action="{{ route('driver.logout') }}" method="POST" class="d-none">
          @csrf
        </form>

        <a href="#" class="btn btn-outline-danger mb-2"
           onclick="event.preventDefault(); document.getElementById('driver-logout-form').submit();">
          Logout
        </a>
      @endauth
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                {{-- ========== 1) Identitas Driver ========== --}}
                @php
                    /** @var \App\Models\Driver $driver */
                    $driver = auth('driver')->user();
                @endphp

                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Identitas Driver</h3>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                @php $fotoPath = $driver->foto ?? null; @endphp
                                @if ($fotoPath)
                                    <img src="{{ asset('storage/'.$fotoPath) }}"
                                         alt="Foto {{ $driver->nama_driver }}"
                                         class="img-thumbnail"
                                         style="max-width:220px;height:auto;">
                                @else
                                    <div class="border rounded d-flex align-items-center justify-content-center"
                                         style="width:220px;height:220px;background:#f7f7f7;">
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
                                                <td><span class="badge badge-success">Aktif</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>

                {{-- ========== 2) Jadwal Driver (Upcoming) ========== --}}
                @php
                    /** @var \Illuminate\Support\Collection $driverTickets */
                    $driverTickets = $driverTickets ?? collect();
                    $nowWIB = \Carbon\Carbon::now('Asia/Jakarta');
                    $upcoming = $driverTickets->filter(function($t) use ($nowWIB) {
                        return optional($t->departure_at)->gt($nowWIB->copy()->utc());
                    });
                @endphp



                {{-- ========== 3) Daftar Tiket Driver + Lihat Penumpang & Titik Jemput ========== --}}
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Tiket Saya</h3>
                    </div>
                    <div class="card-body">
                        @if ($driverTickets->isEmpty())
                            <p class="text-muted mb-0">Belum ada tiket terkait driver ini.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Armada / Kelas</th>
                                            <th>Rute</th>
                                            <th>Berangkat</th>
                                            <th>Tiba</th>
                                            <th>Harga</th>
                                            <th>Penumpang</th>
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
                                                <td>{{ ($t->track->from_route ?? '-') . ' → ' . ($t->track->to_route ?? '-') }}</td>
                                                <td>
                                                    @if($t->departure_at)
                                                        {{ $t->departure_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($t->arrival_at)
                                                        {{ $t->arrival_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @php $p = optional($t->price)->price; @endphp
                                                    {{ $p !== null ? 'Rp '.number_format($p,0,',','.') : '-' }}
                                                </td>
                                                <td>
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

                            {{-- ===== Render SEMUA MODAL di bawah tabel (bukan di dalam tbody) ===== --}}
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
                                                    Penumpang — Tiket #{{ $t->id }} | {{ ($t->track->from_route ?? '-') . ' → ' . ($t->track->to_route ?? '-') }}
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
                                                        <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th><th>ID Order</th>
                                                                        <th>Pemesan</th><th>Penumpang</th>
                                                                        <th>Titik Jemput</th>
                                                                        <th>No. WhatsApp Pemesan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($orders as $k => $o)
                                                                        @php
                                                                            $pemesan = optional($o->user)->name ?? optional($o->user)->username ?? '—';
                                                                            $pickup = $o->pickup_point ?? $o->pickup_location ?? $o->alamat_lengkap ?? '—';
                                                                            $passengerList = $o->passengers?->pluck('name')->filter()->implode(', ') ?? '—';
                                                                            $wa = $o->nowhatsapp ?? $o->no_whatsapp ?? $o->phone ?? '—';
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $k+1 }}</td>
                                                                            <td>{{ $o->id }}</td>
                                                                            <td>{{ $pemesan }}</td>
                                                                            <td>{{ $passengerList }}</td>
                                                                            <td>{{ $pickup }}</td>
                                                                            <td>{{ $wa }}</td>
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
                            {{-- ===== /SEMUA MODAL ===== --}}
                        @endif
                    </div>
                </div>

            </div> {{-- /.container-fluid --}}
        </section>
    </div> {{-- /.content-wrapper --}}
</div> {{-- /.wrapper --}}
@endsection
