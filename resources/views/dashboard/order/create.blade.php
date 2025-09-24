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
                        <h1>Pesanan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Pesanan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        @if (session('error'))
                          <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul class="mb-0">
                                  @foreach ($errors->all() as $err)
                                      <li>{{ $err }}</li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif

                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title">Form Pesanan</h3>
                          </div>

                          <form action="{{ route('orders.store') }}" method="POST" id="wizard-order">
                            @csrf
                            <div class="card-body">

                              {{-- STEP INDICATOR --}}
                              <div class="mb-3">
                                <ul class="nav nav-pills">
                                  <li class="nav-item"><a class="nav-link active"   href="#" data-step="1">1. Cari Tiket</a></li>
                                  <li class="nav-item"><a class="nav-link disabled" href="#" data-step="2">2. Pilih Tiket & Kursi</a></li>
                                  <li class="nav-item"><a class="nav-link disabled" href="#" data-step="3">3. Data Penumpang</a></li>
                                  <li class="nav-item"><a class="nav-link disabled" href="#" data-step="4">4. Pembayaran</a></li>
                                </ul>
                              </div>

                              {{-- ========== SLIDE 1 ========== --}}
                              <div class="step" data-step="1">
                                <h5 class="mb-3">Asal, Tujuan, Tanggal & Jumlah Penumpang</h5>

                                <div class="form-row">
                                  <div class="col-md-4">
                                    <label for="from_route">Asal</label>
                                    <select id="from_route" class="form-control" required>
                                      <option disabled selected value="">Pilih Asal</option>
                                      @php $froms = $tracks->pluck('from_route')->unique()->values(); @endphp
                                      @foreach ($froms as $fr)
                                        <option value="{{ $fr }}">{{ $fr }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-4">
                                    <label for="to_route">Tujuan</label>
                                    <select id="to_route" class="form-control" required>
                                      <option disabled selected value="">Pilih Tujuan</option>
                                      {{-- akan diisi dinamis berdasarkan Asal --}}
                                    </select>
                                  </div>
                                  <div class="col-md-4">
                                    <label for="go_date_search">Tanggal Pergi</label>
                                    <input type="date" id="go_date_search" class="form-control" min="{{ date('Y-m-d') }}" required disabled>
                                  </div>
                                </div>

                                <div class="form-row mt-3">
                                  <div class="col-md-4">
                                    <label>Jumlah Penumpang</label>
                                    <input type="number" class="form-control" name="amount" id="jumlah-penumpang" min="1" required>
                                    <small class="text-muted">Isi jumlah penumpang sesuai kebutuhan.</small>
                                  </div>
                                </div>

                                <div class="mt-3 d-flex align-items-center">
                                  <button type="button" id="btnSearch" class="btn btn-info">Cek Tiket</button>
                                  <span id="searchMsg" class="ml-3"></span>
                                </div>

                                {{-- hidden untuk submit di akhir --}}
                                <input type="hidden" name="ticket_id" id="ticket_id">
                                <input type="hidden" name="go_date"   id="go_date">
                                <input type="hidden" name="selected_seats" id="selected_seats" required>
                              </div>

                              {{-- ========== SLIDE 2 ========== --}}
                              <div class="step d-none" data-step="2">
                                <h5 class="mb-3">Pilih Tiket & Kursi</h5>

                                {{-- daftar tiket --}}
                                <div id="available-tickets" class="mb-3"></div>
                                <small id="remaining-info" class="text-muted d-block mb-2"></small>

                                {{-- FOTO ARMADA (baru, hanya pakai kolom trains.foto_armada & foto_kursi) --}}
                                <div id="fleet-photo-card" class="card mb-3 d-none">
                                  <div class="card-header py-2"><strong>Armada</strong></div>
                                  <div class="card-body text-center">
                                    <img id="fleet-photo" src="" alt="Foto armada" style="max-width:100%;max-height:220px;object-fit:cover;border-radius:8px;">
                                    <div class="text-muted small mt-2" id="fleet-name"></div>
                                  </div>
                                </div>
                                <div id="seat-photo-card" class="card mb-3 d-none">
                                  <div class="card-header py-2"><strong>Foto Kursi</strong></div>
                                  <div class="card-body text-center">
                                    <img id="seat-photo" src="" alt="Foto kursi" style="max-width:100%;max-height:220px;object-fit:cover;border-radius:8px;">
                                  </div>
                                </div>

                                {{-- seat map --}}
                                <style>
                                  .seat { width:40px;height:40px;margin:5px;text-align:center;line-height:40px;border-radius:5px;cursor:pointer;background:#e0e0e0;border:1px solid #ccc; }
                                  .seat.selected { background:#28a745;color:#fff; }
                                  .seat.occupied { background:#dc3545;color:#fff; cursor:not-allowed; }
                                </style>
                                <h6 class="mb-2">Pilih Kursi</h6>
                                <p class="text-muted mb-2">Kursi merah = sudah terisi pada tiket terpilih. Pilih sesuai jumlah penumpang.</p>
                                <div id="seat-map" class="mb-2"></div>
                                <div><strong>Kursi dipilih:</strong> <span id="seat-picked-view">-</span></div>
                              </div>

                              {{-- ========== SLIDE 3 ========== --}}
                              <div class="step d-none" data-step="3">
                                <h5 class="mb-3">Data Pemesan & Penumpang</h5>

                                <div class="form-row mb-3">
                                  <div class="col-md-6">
                                    <label>Alamat Lengkap</label>
                                    <textarea class="form-control" name="alamat_lengkap" rows="2" required>{{ old('alamat_lengkap') }}</textarea>
                                    <small class="text-muted">Contoh: Jl. Merdeka No.123 … (boleh link Google Maps)</small>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Nomor Whatsapp</label>
                                    <input type="text" class="form-control" name="nowhatsapp" placeholder="No. Whatsapp" required value="{{ old('nowhatsapp') }}">
                                  </div>
                                </div>

                                <div id="passenger-forms"></div>
                              </div>

                              {{-- ========== SLIDE 4 ========== --}}
                              <div class="step d-none" data-step="4">
                                <h5 class="mb-3">Pembayaran</h5>

                                <div class="form-row mb-2">
                                  <div class="col-md-4">
                                    <label>Metode Pembayaran</label>
                                    <select class="form-control" name="method_id" required>
                                      <option disabled selected>-- Pilih Metode --</option>
                                      @foreach ($methods as $method)
                                        <option value="{{ $method->id }}">{{ $method->method }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Atas Nama</label>
                                    <input type="text" class="form-control" name="name_account" placeholder="Nama Lengkap" required>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Nomor Rekening</label>
                                    <input type="text" class="form-control" name="from_account" placeholder="No. Rekening" required>
                                  </div>
                                </div>

                                <hr>
                                <div class="text-right">
                                  <button type="submit" class="btn btn-primary px-4">Submit</button>
                                </div>
                              </div>

                              {{-- NAV BUTTONS --}}
                              <hr>
                              <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" id="btnPrev" disabled>Back</button>
                                <button type="button" class="btn btn-primary"   id="btnNext">Next</button>
                              </div>

                            </div>
                          </form>
                        </div>

                        {{-- ==== Data track untuk dependent dropdown ==== --}}
                        <script>
                          window.__TRACKS__ = @json($tracks->map(fn($t)=>[$t->from_route,$t->to_route])->values());
                        </script>

                        {{-- ==== Peta ticket -> assets BARU (hanya foto_armada & foto_kursi) ==== --}}
                        @php
                          $ticketAssets = $tickets->mapWithKeys(function($t){
                              $train = $t->train;
                              return [
                                $t->id => [
                                  'armada' => $train?->foto_armada ? asset('storage/'.$train->foto_armada) : null,
                                  'kursi'  => $train?->foto_kursi  ? asset('storage/'.$train->foto_kursi)  : null,
                                  'name'   => $train->name  ?? null,
                                  'class'  => $train->class ?? null,
                                ]
                              ];
                          });
                        @endphp
                        <script>
                          window.__TICKET_ASSETS__ = @json($ticketAssets);
                        </script>

                        <script>
                        document.addEventListener('DOMContentLoaded', () => {
                          // step controls
                          const steps  = [...document.querySelectorAll('.step')];
                          const pills  = [...document.querySelectorAll('.nav-link[data-step]')];
                          const btnPrev = document.getElementById('btnPrev');
                          const btnNext = document.getElementById('btnNext');

                          // slide 1
                          const fromSel   = document.getElementById('from_route');
                          const toSel     = document.getElementById('to_route');
                          const goDateS   = document.getElementById('go_date_search');
                          const btnSearch = document.getElementById('btnSearch');
                          const searchMsg = document.getElementById('searchMsg');
                          const jumlahSel = document.getElementById('jumlah-penumpang');

                          // hidden submit fields
                          const hiddenTicket = document.getElementById('ticket_id');
                          const hiddenDate   = document.getElementById('go_date');
                          const seatsInput   = document.getElementById('selected_seats');

                          // slide 2 (UI)
                          const listWrap   = document.getElementById('available-tickets');
                          const remainingInfo = document.getElementById('remaining-info');
                          const seatMap    = document.getElementById('seat-map');
                          const seatPickedView = document.getElementById('seat-picked-view');
                          // foto armada/kursi
                          const fleetCard  = document.getElementById('fleet-photo-card');
                          const fleetImg   = document.getElementById('fleet-photo');
                          const fleetName  = document.getElementById('fleet-name');
                          const seatCard   = document.getElementById('seat-photo-card');
                          const seatImg    = document.getElementById('seat-photo');

                          // peta ticket->assets
                          const ticketAssets = window.__TICKET_ASSETS__ || {};

                          let current = 1;

                          // state
                          let ticketsFound = [];   // {ticket_id,label,remaining}
                          let selectedTicketId = null;
                          let occupiedSeats = [];
                          let selectedSeats = [];
                          let remaining = 0;

                          // layout dari server
                          let layoutMatrix = [];

                          // guards
                          let canProceedToStep2 = false;
                          let lastSearchToken   = null;
                          let selectedToken     = null;
                          function token(){ return (Math.random().toString(36).slice(2) + Date.now().toString(36)); }

                          function go(step){
                            current = step;
                            steps.forEach(s => s.classList.toggle('d-none', Number(s.dataset.step) !== step));
                            pills.forEach(p => {
                              const n = Number(p.dataset.step);
                              p.classList.toggle('active', n === step);
                              p.classList.toggle('disabled', n > step);
                            });
                            btnPrev.disabled = (step === 1);
                            btnNext.textContent = (step === 4) ? 'Finish' : 'Next';
                          }

                          function hideFleetAndSeat(){
                            fleetCard?.classList.add('d-none');
                            seatCard?.classList.add('d-none');
                            fleetImg?.removeAttribute('src');
                            seatImg?.removeAttribute('src');
                            if (fleetName) fleetName.textContent = '';
                          }

                          function showPhotos(ticketId){
                            const data = ticketAssets[String(ticketId)] || {};
                            const title = (data.name || '-') + (data.class ? ' ('+data.class+')' : '');
                            if (data.armada) {
                              fleetImg.src = data.armada;
                              fleetImg.alt = 'Armada ' + (data.name || '');
                              fleetName.textContent = title;
                              fleetCard.classList.remove('d-none');
                            } else {
                              fleetCard.classList.add('d-none');
                              fleetImg.removeAttribute('src');
                              fleetName.textContent = '';
                            }
                            if (data.kursi) {
                              seatImg.src = data.kursi;
                              seatImg.alt = 'Kursi ' + (data.name || '');
                              seatCard.classList.remove('d-none');
                            } else {
                              seatCard.classList.add('d-none');
                              seatImg.removeAttribute('src');
                            }
                          }

                          function invalidateResults(reason=''){
                            ticketsFound = [];
                            selectedTicketId = null;
                            occupiedSeats = [];
                            selectedSeats = [];
                            layoutMatrix = [];
                            remaining = 0;
                            canProceedToStep2 = false;
                            lastSearchToken = null;
                            selectedToken   = null;

                            listWrap && (listWrap.innerHTML = '');
                            seatMap && (seatMap.innerHTML = '');
                            remainingInfo && (remainingInfo.textContent = '');
                            seatPickedView && (seatPickedView.textContent = '-');

                            hiddenTicket && (hiddenTicket.value = '');
                            hiddenDate && (hiddenDate.value = '');
                            seatsInput && (seatsInput.value = '');

                            hideFleetAndSeat();
                            go(1);
                            if (searchMsg) {
                              searchMsg.className = 'ml-3 text-muted';
                              searchMsg.textContent = reason ? `Data pencarian direset: ${reason}` : 'Data pencarian direset. Silakan cek ulang.';
                            }
                          }

                          // dependent dropdown Asal → Tujuan
                          const tracks = (window.__TRACKS__ || []);
                          function refreshToOptions() {
                            if (!toSel || !fromSel) return;
                            const pickedFrom = fromSel.value;
                            const tos = [...new Set(tracks.filter(t=>t[0]===pickedFrom).map(t=>t[1]))];
                            toSel.innerHTML = '<option disabled selected value="">Pilih Tujuan</option>';
                            tos.forEach(v=>{
                              const opt = document.createElement('option');
                              opt.value = v; opt.textContent = v;
                              toSel.appendChild(opt);
                            });
                            lockDateIfNoRoute();
                          }
                          function lockDateIfNoRoute() {
                            if (!goDateS) return;
                            const disabled = !(fromSel?.value && toSel?.value);
                            goDateS.disabled = disabled;
                            if (disabled) goDateS.value = '';
                          }
                          fromSel?.addEventListener('change', () => { refreshToOptions(); invalidateResults('parameter berubah'); });
                          toSel?.addEventListener('change', () => { lockDateIfNoRoute(); invalidateResults('parameter berubah'); });
                          goDateS?.addEventListener('change', () => invalidateResults('parameter berubah'));
                          refreshToOptions(); lockDateIfNoRoute();

                          function renderSeatMap() {
                            if (!seatMap) return;
                            seatMap.innerHTML = '';

                            if (!Array.isArray(layoutMatrix) || !layoutMatrix.length) {
                              seatMap.innerHTML = '<div class="text-danger">Layout kursi tidak tersedia.</div>';
                              return;
                            }

                            const occSet = new Set((occupiedSeats || []).map(String));

                            layoutMatrix.forEach(row => {
                              const wrap = document.createElement('div'); wrap.className='d-flex';
                              row.forEach(cell => {
                                if (cell === '' || cell === null) {
                                  const gap = document.createElement('div');
                                  gap.style.cssText = 'width:40px;height:40px;margin:5px;';
                                  wrap.appendChild(gap);
                                  return;
                                }
                                const code = String(cell);
                                const div  = document.createElement('div');
                                const occ  = occSet.has(code);

                                div.className = 'seat' + (occ ? ' occupied' : '');
                                div.dataset.seat = code;
                                div.textContent  = code;

                                if (!occ) {
                                  if (selectedSeats.includes(code)) div.classList.add('selected');
                                  div.addEventListener('click', () => {
                                    const maxPick = parseInt(jumlahSel?.value || '1', 10);
                                    if (div.classList.contains('selected')) {
                                      div.classList.remove('selected');
                                      selectedSeats = selectedSeats.filter(s => s !== code);
                                    } else {
                                      if (selectedSeats.length < maxPick) {
                                        div.classList.add('selected');
                                        selectedSeats.push(code);
                                      } else {
                                        alert('Jumlah kursi tidak boleh lebih dari jumlah penumpang.');
                                      }
                                    }
                                    seatsInput.value = selectedSeats.join(',');
                                    seatPickedView.textContent = selectedSeats.length ? selectedSeats.join(', ') : '-';
                                  });
                                }

                                wrap.appendChild(div);
                              });
                              seatMap.appendChild(wrap);
                            });

                            seatsInput.value = selectedSeats.join(',');
                            seatPickedView.textContent = selectedSeats.length ? selectedSeats.join(', ') : '-';
                          }

                          function renderTicketList(){
                            if (!listWrap) return;
                            listWrap.innerHTML = '';
                            if (!ticketsFound.length) {
                              listWrap.innerHTML = '<div class="text-danger">Tidak ada tiket untuk rute & tanggal tersebut.</div>';
                              hideFleetAndSeat();
                              return;
                            }
                            const group = document.createElement('div');
                            ticketsFound.forEach((t, idx) => {
                              const id = `optTicket${idx}`;
                              const row = document.createElement('div');
                              row.className = 'form-check mb-2';
                              row.innerHTML = `
                                <input class="form-check-input" type="radio" name="optTicket" id="${id}" value="${t.ticket_id}">
                                <label class="form-check-label" for="${id}">
                                  ${t.label} <span class="text-muted">(Sisa: ${t.remaining})</span>
                                </label>`;
                              group.appendChild(row);
                            });
                            listWrap.appendChild(group);

                            group.querySelectorAll('input[name="optTicket"]').forEach(r => {
                              r.addEventListener('change', async e => {
                                if (!canProceedToStep2 || !lastSearchToken) {
                                  alert('Silakan lakukan pencarian lagi.');
                                  invalidateResults('state pencarian tidak valid');
                                  return;
                                }
                                selectedTicketId = Number(e.target.value);
                                hiddenTicket.value = String(selectedTicketId);
                                hiddenDate.value   = goDateS?.value || '';

                                // tampilkan foto armada & kursi untuk tiket terpilih
                                showPhotos(selectedTicketId);

                                // reset pilihan kursi
                                selectedSeats = [];
                                seatsInput.value = '';
                                seatPickedView.textContent = '-';

                                // Ambil layout + occupied dari server
                                try {
                                  const url = `{{ route('orders.availability') }}?` + new URLSearchParams({
                                    ticket_id: selectedTicketId,
                                    go_date: hiddenDate.value
                                  }).toString();
                                  const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
                                  const data = await res.json();
                                  if (!data || data.ok === false) {
                                    alert(data?.message || 'Gagal memuat layout kursi.');
                                    return;
                                  }

                                  layoutMatrix = Array.isArray(data.layout) ? data.layout : [];
                                  occupiedSeats = Array.isArray(data.occupied) ? data.occupied : [];
                                  remainingInfo.textContent = (typeof data.remaining === 'number') ? `Sisa kursi pada tiket ini: ${data.remaining}` : '';

                                  renderSeatMap();
                                  selectedToken = lastSearchToken;
                                } catch(err) {
                                  console.error(err);
                                  alert('Gagal memuat layout kursi dari server.');
                                }
                              });
                            });
                          }

                          function buildPassengerForms(count){
                            const passengerWrap = document.getElementById('passenger-forms');
                            if (!passengerWrap) return;
                            passengerWrap.innerHTML = '';
                            for (let i=1; i<=count; i++){
                              const card = document.createElement('div');
                              card.className = 'card border-0 mb-3';
                              card.innerHTML = `
                                <div class="card-body">
                                  <h6 class="card-title">Penumpang ke-${i}</h6>
                                  <div class="row">
                                    <div class="col-md-4">
                                      <label>Nama</label>
                                      <input type="text" class="form-control" name="nama_penumpang_${i}" required>
                                    </div>
                                    <div class="col-md-4">
                                      <label>Umur</label>
                                      <input type="number" class="form-control" name="umur_penumpang_${i}" min="0" required>
                                    </div>
                                    <div class="col-md-4">
                                      <label>Jenis Kelamin</label>
                                      <select name="jenis_penumpang_${i}" class="form-control">
                                        <option value="true">Laki-laki</option>
                                        <option value="false">Perempuan</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>`;
                              passengerWrap.appendChild(card);
                            }
                          }

                          // SEARCH (Slide 1)
                          btnSearch?.addEventListener('click', async () => {
                            if (searchMsg) { searchMsg.className='ml-3'; searchMsg.textContent=''; }

                            // jangan reset kalau parameter belum lengkap
                            if (!fromSel?.value || !toSel?.value || !goDateS?.value) {
                              searchMsg.classList.add('text-danger');
                              searchMsg.textContent = 'Lengkapi asal, tujuan, dan tanggal.';
                              return;
                            }

                            // reset hasil lama
                            invalidateResults();

                            try {
                              const qs = new URLSearchParams({
                                from_route: fromSel.value,
                                to_route:   toSel.value,
                                go_date:    goDateS.value
                              }).toString();

                              const res = await fetch(`{{ route('orders.search') }}?${qs}`, {
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                              });
                              const data = await res.json();

                              if (!data.ok) {
                                searchMsg.classList.add('text-danger');
                                // Tampilkan pesan spesifik sesuai reason dari server
                                switch (data.reason) {
                                  case 'no_route':
                                    searchMsg.textContent = 'Rute tidak tersedia untuk kombinasi asal & tujuan tersebut.';
                                    break;
                                  case 'no_ticket_for_route':
                                    searchMsg.textContent = 'Belum ada tiket untuk rute ini.';
                                    break;
                                  case 'no_ticket_on_date':
                                    searchMsg.textContent = 'Tidak ada tiket tersedia pada tanggal tersebut.';
                                    break;
                                  case 'invalid_date':
                                    searchMsg.textContent = 'Tanggal tidak valid.';
                                    break;
                                  default:
                                    searchMsg.textContent = data.message || 'Tiket tidak tersedia.';
                                }
                                return;
                              }

                              ticketsFound   = data.tickets;
                              lastSearchToken = token();
                              canProceedToStep2 = true;

                              searchMsg.classList.add('text-success');
                              searchMsg.textContent = `Ditemukan ${ticketsFound.length} tiket tersedia. Klik Next untuk pilih tiket & kursi.`;
                              hiddenDate.value = goDateS.value; // simpan tanggal
                            } catch (e) {
                              console.error(e);
                              searchMsg.classList.add('text-danger');
                              searchMsg.textContent = 'Gagal mencari tiket.';
                            }
                          });

                          // NAV
                          btnPrev?.addEventListener('click', () => { if (current > 1) go(current - 1); });

                          btnNext?.addEventListener('click', async () => {
                            if (current === 1) {
                              if (!canProceedToStep2 || !lastSearchToken) {
                                alert('Silakan klik "Cek Tiket" dan pastikan ada tiket tersedia.');
                                return;
                              }
                              const j = parseInt(jumlahSel?.value || '1', 10);
                              if (j < 1) { alert('Jumlah penumpang tidak valid.'); return; }
                              go(2);
                              renderTicketList();
                              // kosongkan seat map & foto
                              occupiedSeats = [];
                              selectedSeats = []; seatsInput.value = ''; seatPickedView.textContent = '-';
                              layoutMatrix = []; seatMap.innerHTML = '';
                              hideFleetAndSeat();
                              return;
                            }

                            if (current === 2) {
                              // wajib pilih tiket, token harus cocok
                              if (!selectedTicketId) { alert('Pilih salah satu tiket dahulu.'); return; }
                              if (!canProceedToStep2 || !lastSearchToken || selectedToken !== lastSearchToken) {
                                alert('Parameter pencarian berubah. Silakan cek tiket lagi.');
                                invalidateResults('token tidak cocok');
                                return;
                              }
                              const j = parseInt(jumlahSel?.value || '1', 10);
                              if (selectedSeats.length !== j) { alert('Jumlah kursi dipilih harus sama dengan jumlah penumpang.'); return; }

                              // re-check availability + sync layout
                              try {
                                const url = `{{ route('orders.availability') }}?` + new URLSearchParams({
                                  ticket_id: selectedTicketId,
                                  go_date: hiddenDate?.value || goDateS?.value || ''
                                }).toString();
                                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
                                const data = await res.json();

                                if (!data || data.ok === false) {
                                  alert(data?.message || 'Gagal validasi ketersediaan.');
                                  return;
                                }

                                if (Array.isArray(data.layout)) layoutMatrix = data.layout;
                                if (Array.isArray(data.occupied)) occupiedSeats = data.occupied;

                                // batalkan kalau ada bentrok
                                const occ = new Set((occupiedSeats || []).map(String));
                                const bentrok = selectedSeats.some(s => occ.has(String(s)));
                                if (bentrok) {
                                  renderSeatMap();
                                  alert('Sebagian kursi yang Anda pilih sudah terisi. Silakan pilih kursi lain.');
                                  return;
                                }
                              } catch (e) {
                                console.error(e);
                                alert('Gagal validasi ketersediaan. Coba lagi.');
                                return;
                              }

                              // build forms sesuai jumlah
                              buildPassengerForms(parseInt(jumlahSel.value,10));
                              go(3);
                              return;
                            }

                            if (current === 3) { go(4); return; }

                            if (current === 4) {
                              if (!hiddenTicket.value) { alert('Tiket belum dipilih.'); go(2); return; }
                              if (!seatsInput.value) { alert('Kursi belum dipilih.'); go(2); return; }
                              document.getElementById('wizard-order')?.submit();
                              return;
                            }
                          });

                          // Nonaktifkan klik langsung pada pill nav
                          pills.forEach(p => p.addEventListener('click', e => e.preventDefault()));

                          // init
                          go(1);
                        });
                        </script>

                    </div>
                </div>
            </div>
            
        </section>
    </div>

    <footer class="main-footer">
        <strong>Sonic &copy; {{ date('Y') }}.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block"></div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
@endsection
