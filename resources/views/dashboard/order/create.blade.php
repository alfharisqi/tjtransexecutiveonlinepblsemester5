@extends('layouts.front')

@section('front')
<div class="wrapper">
  <x-front-dashboard-navbar></x-front-dashboard-navbar>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/dashboard" class="brand-link">
      <img src="{{ asset('favicon.ico') }}" class="brand-image img-circle elevation-3" style="opacity:.8" alt="TJ Trans Executive">
      <span class="brand-text font-weight-light">TJ Trans Executive</span>
    </a>
    <x-front-sidemenu></x-front-sidemenu>
  </aside>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1>Pesanan</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Pesanan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">

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

        {{-- ======== STYLE (Traveloka-ish) ======== --}}
        <style>
          /* wizard pills */
          .wizard-pills .nav-link{border-radius:999px;padding:.5rem .9rem}
          .wizard-pills .nav-link.active{background:#176BFF;color:#fff}
          .wizard-pills .nav-link.disabled{opacity:.55;cursor:not-allowed}

          /* search bar */
          .tvl-hero{background:linear-gradient(160deg,#176BFF 0%,#0F56C8 100%);border-radius:18px;padding:16px}
          .tvl-bar{display:flex;align-items:center;background:#fff;border-radius:999px;padding:10px 12px;gap:12px}
          .tvl-chip{display:flex;align-items:center;gap:10px;padding:10px 14px;border-right:1px solid #e5e7eb}
          .tvl-chip:last-child{border-right:0}
          .tvl-ic{font-size:18px;color:#176BFF}
          .tvl-label{font-size:12px;color:#6b7280;margin-bottom:2px}
          .tvl-field{border:0;outline:0;min-width:170px;background:transparent}
          .tvl-swap{width:38px;height:38px;border-radius:999px;border:1px dashed rgba(23,107,255,.35);background:#fff;display:flex;align-items:center;justify-content:center}
          .tvl-search{margin-left:auto;display:flex;align-items:center;justify-content:center;width:56px;height:56px;border:0;border-radius:18px;background:#fff;color:#fff;font-size:20px}
          .tvl-help{color:#dbe7ff}

          /* badges */
          .tw-badge{display:inline-block;padding:4px 10px;font-size:12px;border-radius:999px;background:#eef2ff;color:#3f51b5}
          .tw-badge.red{background:#fee2e2;color:#b91c1c}

          /* tickets */
          .tvl-card{border:1px solid #eef2f7;border-radius:14px;padding:14px;margin-bottom:12px;background:#fff;cursor:pointer}
          .tvl-card:hover{box-shadow:0 8px 22px rgba(2,12,27,.06)}
          .tvl-card.active{outline:2px solid #176BFF}
          .tvl-price{font-weight:800;font-size:20px}
          .tvl-skeleton{position:relative;overflow:hidden;background:#eef2f7;border-radius:14px;height:64px}
          .tvl-skeleton:after{content:"";position:absolute;inset:0;transform:translateX(-100%);background:linear-gradient(90deg,transparent,rgba(255,255,255,.8),transparent);animation:ske 1.25s infinite}
          @keyframes ske{100%{transform:translateX(100%)}}

          /* seat & photos */
          .tvl-stage{display:grid;grid-template-columns:1.25fr .75fr;gap:16px}
          .tvl-photo{width:100%;max-height:240px;object-fit:cover;border-radius:10px}
          .seat-wrap{border:1px dashed #e5e7eb;border-radius:12px;padding:12px;background:#fafafa}
          .seat{width:40px;height:40px;margin:6px;text-align:center;line-height:40px;border-radius:6px;cursor:pointer;background:#e0e0e0;border:1px solid #ccc;font-weight:600}
          .seat.selected{background:#28a745;color:#fff}
          .seat.occupied{background:#dc3545;color:#fff;cursor:not-allowed}
          @media(max-width:768px){.tvl-field{min-width:130px}.tvl-stage{grid-template-columns:1fr}}
        </style>
        <style>
/* ====== MOBILE FIXES (<768px) ====== */
@media (max-width: 767.98px) {

  .wizard-pills .nav {
    overflow-x: auto;
    white-space: nowrap;
    gap: 4px;
  }
  .wizard-pills .nav-link {
    flex: 0 0 auto;
    padding: .35rem .7rem;
    font-size: 13px;
  }

  .tvl-bar {
    flex-direction: column;
    align-items: stretch;
    gap: 6px;
    padding: 8px;
    border-radius: 10px;
  }

  .tvl-chip {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 8px 10px;
  }

  .tvl-field {
    min-width: 0;
    width: 100%;
  }
  .tvl-select,
  .tvl-input,
  .tvl-date {
    width: 100%;
    font-size: 13px;
    padding: 4px 0;
  }

  .tvl-ic { font-size: 14px; }
  .tvl-swap {
    width: 30px;
    height: 30px;
    align-self: center;
    order: 3;
  }

  .tvl-search {
    width: 100%;
    height: 42px;
    border-radius: 10px;
    margin-left: 0;
    font-size: 16px;
    font-weight: 600;
  }

  .tvl-hero {
    padding: 10px;
    border-radius: 12px;
  }
  .tvl-card {
    padding: 10px;
  }
  .tvl-price {
    font-size: 16px;
  }

  .tvl-stage {
    grid-template-columns: 1fr;
  }

  .seat {
    width: 32px;
    height: 32px;
    line-height: 32px;
    margin: 4px;
    font-size: 13px;
  }

  .content .btn {
    min-height: 38px;
    font-size: 14px;
    padding: 6px 10px;
  }

  .card-body {
    padding: 10px 12px;
  }
  .card-header {
    padding: 8px 12px;
  }
}

/* ====== VERY SMALL (<=360px) ====== */
@media (max-width: 360px) {
  .seat {
    width: 28px;
    height: 28px;
    line-height: 28px;
    margin: 3px;
    font-size: 12px;
  }
  .tvl-label {
    font-size: 10px;
  }
  .tvl-search {
    height: 38px;
    font-size: 14px;
  }
}
</style>


        <div class="card border-0">
          <div class="card-header bg-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Form Pesanan</strong>
                <div class="small text-muted">Lengkapi data pemesanan Anda.</div>
              </div>
            </div>
          </div>

          <form action="{{ route('orders.store') }}" method="POST" id="wizard-order">
          @csrf
          <div class="card-body">

            {{-- STEP PILLS --}}
            <div class="wizard-pills mb-3">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active"   href="#" data-step="1">1. Cari Tiket</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="#" data-step="2">2. Pilih Tiket & Kursi</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="#" data-step="3">3. Data Penumpang</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="#" data-step="4">4. Pembayaran</a></li>
              </ul>
            </div>

            {{-- =================== SLIDE 1 =================== --}}
            <div class="step" data-step="1">
              <div class="tvl-hero">
                <div class="tvl-bar">
                  {{-- From --}}
                  <div class="tvl-chip">
                    <span class="tvl-ic">🚌</span>
                    <div>
                      <div class="tvl-label">Dari</div>
                      <select id="from_route" class="tvl-field" required>
                        <option disabled selected value="">Pilih Asal</option>
                        @php $froms = $tracks->pluck('from_route')->unique()->values(); @endphp
                        @foreach ($froms as $fr)
                          <option value="{{ $fr }}">{{ $fr }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  {{-- Tukar --}}
                  <button type="button" class="tvl-swap" id="swapFromTo" title="Tukar asal & tujuan">⇄</button>

                  {{-- To --}}
                  <div class="tvl-chip">
                    <span class="tvl-ic">🚌</span>
                    <div>
                      <div class="tvl-label">Ke</div>
                      <select id="to_route" class="tvl-field" required>
                        <option disabled selected value="">Pilih Tujuan</option>
                      </select>
                    </div>
                  </div>

                  {{-- Date --}}
                  <div class="tvl-chip">
                    <span class="tvl-ic">📅</span>
                    <div>
                      <div class="tvl-label">Tanggal berangkat</div>
                      <input type="date" id="go_date_search" class="tvl-field" min="{{ date('Y-m-d') }}" required disabled>
                    </div>
                  </div>

                  {{-- Pax --}}
                  <div class="tvl-chip">
                    <span class="tvl-ic">👤</span>
                    <div>
                      <div class="tvl-label">Jumlah penumpang</div>
                      <input type="number" id="jumlah-penumpang" name="amount" class="tvl-field" min="1" value="1" required>
                    </div>
                  </div>

                  {{-- Search --}}
                  <button type="button" class="tvl-search" id="btnSearch" title="Cek Tiket">🔍</button>
                </div>
                <div id="searchMsg" class="tvl-help mt-2"></div>
              </div>

              {{-- hidden for submit --}}
              <input type="hidden" id="ticket_id" name="ticket_id">
              <input type="hidden" id="go_date"   name="go_date">
              <input type="hidden" id="selected_seats" name="selected_seats" required>
            </div>

            {{-- =================== SLIDE 2 =================== --}}
            <div class="step d-none" data-step="2">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="mb-0">Pilih Tiket & Kursi</h5>
                <div class="d-flex" style="gap:10px">
                  <select id="filterClass" class="form-control form-control-sm">
                    <option value="">Semua Kelas</option>
                    <option value="Executive">Executive</option>
                    <option value="VIP">VIP</option>
                    <option value="Regular">Regular</option>
                  </select>
                  <select id="sortBy" class="form-control form-control-sm">
                    <option value="time_asc">Waktu berangkat (awal)</option>
                    <option value="time_desc">Waktu berangkat (akhir)</option>
                    <option value="price_asc">Harga termurah</option>
                    <option value="price_desc">Harga termahal</option>
                  </select>
                </div>
              </div>

              <div id="available-tickets" class="mb-3">
                <div class="tvl-skeleton mb-2"></div>
                <div class="tvl-skeleton"></div>
              </div>
              <small id="remaining-info" class="text-muted d-block mb-2"></small>

              <div class="tvl-stage">
                <div>
                  <div id="fleet-photo-card" class="card mb-3 d-none">
                    <div class="card-header py-2"><strong>Armada</strong></div>
                    <div class="card-body text-center">
                      <img id="fleet-photo" class="tvl-photo" alt="Armada">
                      <div id="fleet-name" class="text-muted small mt-2"></div>
                    </div>
                  </div>
                  <div id="seat-photo-card" class="card mb-3 d-none">
                    <div class="card-header py-2"><strong>Foto Kursi</strong></div>
                    <div class="card-body text-center">
                      <img id="seat-photo" class="tvl-photo" alt="Kursi">
                    </div>
                  </div>
                </div>

                <div>
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Pilih Kursi</h6>
                        <div class="d-flex align-items-center" style="gap:10px">
                          <span style="width:18px;height:18px;background:#e0e0e0;border:1px solid #ccc;border-radius:4px;display:inline-block"></span><small class="text-muted">Kosong</small>
                          <span style="width:18px;height:18px;background:#dc3545;border:1px solid #ccc;border-radius:4px;display:inline-block"></span><small class="text-muted">Terisi</small>
                          <span style="width:18px;height:18px;background:#28a745;border:1px solid #ccc;border-radius:4px;display:inline-block"></span><small class="text-muted">Dipilih</small>
                        </div>
                      </div>
                      <p class="text-muted mb-2">Pilih kursi sesuai jumlah penumpang.</p>
                      <div class="seat-wrap">
                        <div id="seat-map" class="mb-2"></div>
                        <div class="small"><strong>Kursi dipilih:</strong> <span id="seat-picked-view">-</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- =================== SLIDE 3 =================== --}}
            <div class="step d-none" data-step="3">
              <h5 class="mb-3">Data Pemesan & Penumpang</h5>
              <div class="form-row mb-3">
                <div class="col-md-6">
                  <label>Alamat Lengkap</label>
                  <textarea class="form-control" name="alamat_lengkap" rows="2" required>{{ old('alamat_lengkap') }}</textarea>
                  <small class="text-muted">Contoh: Jl. Merdeka No.123 (boleh link Google Maps)</small>
                </div>
                <div class="col-md-4">
                  <label>Nomor Whatsapp</label>
                  <input type="text" class="form-control" name="nowhatsapp" value="{{ old('nowhatsapp') }}" required>
                </div>
              </div>
              <div id="passenger-forms"></div>
            </div>

            {{-- =================== SLIDE 4 =================== --}}
            <div class="step d-none" data-step="4">
              <h5 class="mb-3">Pembayaran</h5>

              @php
                $methodsMap = $methods->mapWithKeys(function($m){
                  return [$m->id => [
                    'name'   => $m->method,
                    'account'=> $m->target_account,
                    'foto'   => $m->foto_method ? asset('storage/'.$m->foto_method) : null,
                  ]];
                });
              @endphp
              <script>window.__METHODS_MAP__ = @json($methodsMap);</script>

              <div class="form-row mb-2">
                <div class="col-md-6">
                  <label>Metode Pembayaran</label>
                  <select class="form-control" name="method_id" id="method_id" required>
                    <option disabled selected>-- Pilih Metode --</option>
                    @foreach ($methods as $method)
                      <option value="{{ $method->id }}">{{ $method->method }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <div class="card" id="method-preview" style="display:none">
                    <div class="card-body d-flex align-items-center">
                      <img id="method-foto" style="width:80px;height:80px;object-fit:cover;border-radius:8px;margin-right:12px;display:none" alt="Metode">
                      <div>
                        <div id="method-name" class="font-weight-bold">-</div>
                        <div class="text-muted small">Rekening Tujuan: <span id="method-account">-</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-row mb-2">
                <div class="col-md-4">
                  <label>Atas Nama</label>
                  <input type="text" class="form-control" name="name_account" required>
                </div>
                <div class="col-md-4">
                  <label>Nomor Rekening</label>
                  <input type="text" class="form-control" name="from_account" required>
                </div>
              </div>

              <hr>
              <div class="text-right">
                <button type="submit" class="btn btn-primary px-4">Submit</button>
              </div>
            </div>

            {{-- NAV --}}
            <hr>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" id="btnPrev" disabled>Back</button>
              <button type="button" class="btn btn-primary" id="btnNext">Next</button>
            </div>

          </div>
          </form>
        </div>

        {{-- ===== Data untuk JS ===== --}}
        <script>window.__TRACKS__ = @json($tracks->map(fn($t)=>[$t->from_route,$t->to_route])->values());</script>
        @php
          $ticketAssets = $tickets->mapWithKeys(function($t){
            $train = $t->train;
            return [$t->id => [
              'armada' => $train?->foto_armada ? asset('storage/'.$train->foto_armada) : null,
              'kursi'  => $train?->foto_kursi  ? asset('storage/'.$train->foto_kursi)  : null,
              'name'   => $train->name  ?? null,
              'class'  => $train->class ?? null,
            ]];
          });
        @endphp
        <script>window.__TICKET_ASSETS__ = @json($ticketAssets);</script>

        {{-- =================== SCRIPT =================== --}}
        <script>
        document.addEventListener('DOMContentLoaded', () => {
          // ---- metode preview ----
          const methodsMap = window.__METHODS_MAP__ || {};
          const methodSelect = document.getElementById('method_id');
          const prevCard = document.getElementById('method-preview');
          const prevImg  = document.getElementById('method-foto');
          const prevName = document.getElementById('method-name');
          const prevAcc  = document.getElementById('method-account');
          methodSelect?.addEventListener('change', e => {
            const m = methodsMap[String(e.target.value)];
            if (!m) { prevCard.style.display='none'; return; }
            prevName.textContent = m.name || '-';
            prevAcc.textContent  = m.account || '-';
            if (m.foto) { prevImg.src=m.foto; prevImg.style.display=''; } else { prevImg.removeAttribute('src'); prevImg.style.display='none'; }
            prevCard.style.display='';
          });

          // ---- VARS ----
          const steps=[...document.querySelectorAll('.step')];
          const pills=[...document.querySelectorAll('.nav-link[data-step]')];
          const btnPrev=document.getElementById('btnPrev');
          const btnNext=document.getElementById('btnNext');

          const fromSel=document.getElementById('from_route');
          const toSel=document.getElementById('to_route');
          const goDateS=document.getElementById('go_date_search');
          const btnSearch=document.getElementById('btnSearch');
          const searchMsg=document.getElementById('searchMsg');
          const jumlahSel=document.getElementById('jumlah-penumpang');

          const hiddenTicket=document.getElementById('ticket_id');
          const hiddenDate=document.getElementById('go_date');
          const seatsInput=document.getElementById('selected_seats');

          const listWrap=document.getElementById('available-tickets');
          const remainingInfo=document.getElementById('remaining-info');
          const seatMap=document.getElementById('seat-map');
          const seatPickedView=document.getElementById('seat-picked-view');

          const fleetCard=document.getElementById('fleet-photo-card');
          const fleetImg=document.getElementById('fleet-photo');
          const fleetName=document.getElementById('fleet-name');
          const seatCard=document.getElementById('seat-photo-card');
          const seatImg=document.getElementById('seat-photo');

          const filterClass=document.getElementById('filterClass');
          const sortBy=document.getElementById('sortBy');

          const ticketAssets=window.__TICKET_ASSETS__ || {};

          // Step 3 elements for validation
          const step3El = document.querySelector('.step[data-step="3"]');
          const alamatField = document.querySelector('textarea[name="alamat_lengkap"]');
          const waField = document.querySelector('input[name="nowhatsapp"]');

          // Step 4 elements for validation (metode pembayaran)
          const step4El       = document.querySelector('.step[data-step="4"]');
          const methodField   = document.getElementById('method_id');
          const nameAccField  = document.querySelector('input[name="name_account"]');
          const fromAccField  = document.querySelector('input[name="from_account"]');


          let current=1,ticketsFound=[],ticketsFiltered=[],selectedTicketId=null,occupiedSeats=[],selectedSeats=[],layoutMatrix=[];
          let canProceedToStep2=false,lastSearchToken=null,selectedToken=null;

          function token(){return(Math.random().toString(36).slice(2)+Date.now().toString(36))}

          function go(step){
            current=step;
            steps.forEach(s=>s.classList.toggle('d-none',Number(s.dataset.step)!==step));
            pills.forEach(p=>{const n=Number(p.dataset.step);p.classList.toggle('active',n===step);p.classList.toggle('disabled',n>step);});
            btnPrev.disabled=(step===1);
            btnNext.textContent=(step===4)?'Finish':'Next';
          }
          pills.forEach(p=>p.addEventListener('click',e=>e.preventDefault()));

          // helper error UI
          function clearFieldError(field) {
            if (!field) return;
            field.classList.remove('is-invalid');
            const fb = field.parentElement.querySelector('.invalid-feedback');
            if (fb) fb.textContent = '';
          }
          function setFieldError(field, msg) {
            if (!field) return;
            field.classList.add('is-invalid');
            let fb = field.parentElement.querySelector('.invalid-feedback');
            if (!fb) {
              fb = document.createElement('div');
              fb.className = 'invalid-feedback';
              field.parentElement.appendChild(fb);
            }
            fb.textContent = msg;
          }

          function validateStep3() {
            if (!step3El) return true;
            let ok = true;

            // reset semua error di step 3
            step3El.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            step3El.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            // alamat wajib
            if (alamatField) {
              const v = (alamatField.value || '').trim();
              if (!v) {
                setFieldError(alamatField, 'Alamat wajib diisi.');
                ok = false;
              }
            }

            // WhatsApp wajib & angka saja
            if (waField) {
              const v = (waField.value || '').trim();
              if (!v) {
                setFieldError(waField, 'Nomor Whatsapp wajib diisi.');
                ok = false;
              } else if (!/^[0-9]+$/.test(v)) {
                setFieldError(waField, 'Nomor Whatsapp hanya boleh angka.');
                ok = false;
              }
            }

            // Nama penumpang wajib & tidak boleh ada angka
            const nameInputs = step3El.querySelectorAll('input[name^="nama_penumpang_"]');
            nameInputs.forEach(inp => {
              const v = (inp.value || '').trim();
              if (!v) {
                setFieldError(inp, 'Nama penumpang wajib diisi.');
                ok = false;
              } else if (/[0-9]/.test(v)) {
                setFieldError(inp, 'Nama tidak boleh mengandung angka.');
                ok = false;
              }
            });

            // Umur penumpang wajib (kalau mau)
            const umurInputs = step3El.querySelectorAll('input[name^="umur_penumpang_"]');
            umurInputs.forEach(inp => {
              const v = (inp.value || '').trim();
              if (!v) {
                setFieldError(inp, 'Umur penumpang wajib diisi.');
                ok = false;
              }
            });

            if (!ok) {
              const firstInvalid = step3El.querySelector('.is-invalid');
              if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
              }
            }

            return ok;
          }

          function validateStep4() {
          if (!step4El) return true;
          let ok = true;

          // reset error di step 4
          step4El.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
          step4El.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

          // Metode pembayaran wajib
          if (methodField) {
            const v = (methodField.value || '').trim();
            if (!v || v === '-- Pilih Metode --') {
              setFieldError(methodField, 'Metode pembayaran wajib dipilih.');
              ok = false;
            }
          }

          // Atas Nama wajib & tidak boleh ada angka
          if (nameAccField) {
            const v = (nameAccField.value || '').trim();
            if (!v) {
              setFieldError(nameAccField, 'Atas Nama wajib diisi.');
              ok = false;
            } else if (/[0-9]/.test(v)) {
              setFieldError(nameAccField, 'Atas Nama tidak boleh mengandung angka.');
              ok = false;
            }
          }

          // Nomor Rekening wajib & hanya angka
          if (fromAccField) {
            const v = (fromAccField.value || '').trim();
            if (!v) {
              setFieldError(fromAccField, 'Nomor rekening wajib diisi.');
              ok = false;
            } else if (!/^[0-9]+$/.test(v)) {
              setFieldError(fromAccField, 'Nomor rekening hanya boleh angka.');
              ok = false;
            }
          }

          if (!ok) {
            const firstInvalid = step4El.querySelector('.is-invalid');
            if (firstInvalid) {
              firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
          }

          return ok;
        }


          // dependent dropdown
          const tracks=(window.__TRACKS__||[]);
          function refreshToOptions(){
            const pickedFrom=fromSel.value;
            const tos=[...new Set(tracks.filter(t=>t[0]===pickedFrom).map(t=>t[1]))];
            toSel.innerHTML='<option disabled selected value="">Pilih Tujuan</option>';
            tos.forEach(v=>{const o=document.createElement('option');o.value=v;o.textContent=v;toSel.appendChild(o);});
            lockDate();
          }
          function lockDate(){
            const disabled=!(fromSel?.value && toSel?.value);
            goDateS.disabled=disabled; if(disabled) goDateS.value='';
          }
          fromSel?.addEventListener('change',()=>{refreshToOptions(); resetSearch('parameter berubah')});
          toSel?.addEventListener('change',()=>{lockDate(); resetSearch('parameter berubah')});
          goDateS?.addEventListener('change',()=>resetSearch('parameter berubah'));
          refreshToOptions(); lockDate();

          // swap
          document.getElementById('swapFromTo')?.addEventListener('click',()=>{
            const a=fromSel.value,b=toSel.value; if(!a||!b) return;
            fromSel.value=b; refreshToOptions(); toSel.value=a; lockDate(); resetSearch('swap asal-tujuan');
          });

          function hidePhotos(){
            fleetCard.classList.add('d-none'); seatCard.classList.add('d-none');
            fleetImg.removeAttribute('src'); seatImg.removeAttribute('src'); fleetName.textContent='';
          }
          function resetSearch(msg=''){
            ticketsFound=[];ticketsFiltered=[];selectedTicketId=null;occupiedSeats=[];selectedSeats=[];layoutMatrix=[];
            canProceedToStep2=false;lastSearchToken=null;selectedToken=null;
            listWrap.innerHTML=''; seatMap.innerHTML=''; remainingInfo.textContent=''; seatPickedView.textContent='-';
            hiddenTicket.value=''; hiddenDate.value=''; seatsInput.value=''; hidePhotos(); go(1);
            searchMsg.textContent = msg?`Reset: ${msg}`:'';
          }

          // render seat map
          function renderSeatMap(){
            seatMap.innerHTML='';
            if(!Array.isArray(layoutMatrix)||!layoutMatrix.length){ seatMap.innerHTML='<div class="text-danger">Layout kursi tidak tersedia.</div>'; return;}
            const occSet=new Set((occupiedSeats||[]).map(String));
            layoutMatrix.forEach(row=>{
              const wrap=document.createElement('div'); wrap.className='d-flex flex-wrap';
              row.forEach(cell=>{
                if(cell===''||cell===null){const gap=document.createElement('div');gap.style.cssText='width:40px;height:40px;margin:6px;';wrap.appendChild(gap);return;}
                const code=String(cell);
                const div=document.createElement('div'); const occ=occSet.has(code);
                div.className='seat'+(occ?' occupied':''); div.textContent=code;
                if(!occ){
                  if(selectedSeats.includes(code)) div.classList.add('selected');
                  div.addEventListener('click',()=>{
                    const maxPick=parseInt(jumlahSel?.value||'1',10);
                    if(div.classList.contains('selected')){div.classList.remove('selected');selectedSeats=selectedSeats.filter(s=>s!==code);}
                    else{ if(selectedSeats.length<maxPick){div.classList.add('selected');selectedSeats.push(code);} else{alert('Jumlah kursi tidak boleh lebih dari jumlah penumpang.');}}
                    seatsInput.value=selectedSeats.join(','); seatPickedView.textContent=selectedSeats.length?selectedSeats.join(', '):'-';
                  });
                }
                wrap.appendChild(div);
              });
              seatMap.appendChild(wrap);
            });
            seatsInput.value=selectedSeats.join(','); seatPickedView.textContent=selectedSeats.length?selectedSeats.join(', '):'-';
          }

          // list tickets
          function applyFilterSort(){
            const cls=filterClass?.value||'';
            ticketsFiltered=ticketsFound.filter(t=>!cls || (t.class||'').toLowerCase()===cls.toLowerCase());
            const key=sortBy?.value||'time_asc';
            ticketsFiltered.sort((a,b)=>{
              if(key==='time_asc')   return (a.depart_at||'').localeCompare(b.depart_at||'');
              if(key==='time_desc')  return (b.depart_at||'').localeCompare(a.depart_at||'');
              if(key==='price_asc')  return (Number(a.price||0)-Number(b.price||0));
              if(key==='price_desc') return (Number(b.price||0)-Number(a.price||0));
              return 0;
            });
          }
          function rp(v){try{return 'Rp '+Number(v||0).toLocaleString('id-ID')}catch{return 'Rp '+v}}

          function renderList(){
            applyFilterSort(); listWrap.innerHTML='';
            if(!ticketsFiltered.length){listWrap.innerHTML='<div class="alert alert-warning">Tidak ada tiket yang cocok.</div>'; hidePhotos(); return;}
            const frag=document.createDocumentFragment();
            ticketsFiltered.forEach((t,i)=>{
              const card=document.createElement('div'); card.className='tvl-card'; card.dataset.ticketId=t.ticket_id;
              card.innerHTML=`
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="font-weight-bold">${t.label||''}</div>
                    <div class="text-muted small">Kelas: <strong>${t.class||'-'}</strong> · Berangkat <strong>${t.depart_at||'-'}</strong> · Tiba <strong>${t.arrive_at||'-'}</strong></div>
                    <div class="mt-1"><span class="tw-badge ${Number(t.remaining||0)<=3?'red':''}">Sisa ${t.remaining??'-'}</span></div>
                  </div>
                  <div class="text-right">
                    <div class="tvl-price">${t.price?rp(t.price):'Rp -'}</div>
                    <div class="form-check mt-2">
                      <input class="form-check-input" type="radio" name="optTicket" value="${t.ticket_id}">
                      <label class="form-check-label small">Pilih</label>
                    </div>
                  </div>
                </div>`;
              frag.appendChild(card);
            });
            listWrap.appendChild(frag);

            function choose(ticketId, cardEl){
              if(!canProceedToStep2 || !lastSearchToken){alert('Silakan cek tiket lagi.');resetSearch('state tidak valid');return;}
              selectedTicketId=Number(ticketId);
              hiddenTicket.value=String(selectedTicketId);
              hiddenDate.value=goDateS?.value||'';
              selectedToken=lastSearchToken;

              listWrap.querySelectorAll('.tvl-card').forEach(c=>c.classList.remove('active'));
              cardEl?.classList.add('active');
              const r=listWrap.querySelector(`input[name="optTicket"][value="${ticketId}"]`); if(r) r.checked=true;

              const a=(ticketAssets||{})[String(selectedTicketId)]||{};
              if(a.armada){fleetImg.src=a.armada;fleetName.textContent=(a.name||'-')+(a.class?` (${a.class})`:'');fleetCard.classList.remove('d-none');} else {fleetCard.classList.add('d-none');fleetImg.removeAttribute('src');fleetName.textContent='';}
              if(a.kursi){seatImg.src=a.kursi;seatCard.classList.remove('d-none');} else {seatCard.classList.add('d-none');seatImg.removeAttribute('src');}

              selectedSeats=[]; seatsInput.value=''; seatPickedView.textContent='-';
              (async()=>{
                try{
                  const url=`{{ route('orders.availability') }}?`+new URLSearchParams({ticket_id:selectedTicketId,go_date:hiddenDate.value}).toString();
                  const res=await fetch(url,{headers:{'X-Requested-With':'XMLHttpRequest'}}); const data=await res.json();
                  if(!data || data.ok===false){alert(data?.message||'Gagal memuat layout kursi.');return;}
                  layoutMatrix=Array.isArray(data.layout)?data.layout:[]; occupiedSeats=Array.isArray(data.occupied)?data.occupied:[];
                  remainingInfo.textContent=typeof data.remaining==='number'?`Sisa kursi pada tiket ini: ${data.remaining}`:'';
                  renderSeatMap(); selectedToken=lastSearchToken;
                }catch(e){console.error(e);alert('Gagal memuat layout kursi.');}
              })();
            }

            listWrap.querySelectorAll('.tvl-card').forEach(c=>{
              c.addEventListener('click',()=>choose(c.dataset.ticketId,c));
              c.querySelector('input[name="optTicket"]')?.addEventListener('change',e=>choose(e.target.value,c));
            });
          }

          filterClass?.addEventListener('change',renderList);
          sortBy?.addEventListener('change',renderList);

          function buildPassengers(n){
            const wrap=document.getElementById('passenger-forms'); wrap.innerHTML='';
            for(let i=1;i<=n;i++){
              const card=document.createElement('div'); card.className='card border-0 mb-3';
              card.innerHTML=`
                <div class="card-body">
                  <h6 class="card-title mb-2">Penumpang ke-${i}</h6>
                  <div class="row">
                    <div class="col-md-4 mb-2">
                      <label>Nama</label>
                      <input name="nama_penumpang_${i}" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label>Umur</label>
                      <input type="number" min="0" name="umur_penumpang_${i}" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label>Jenis Kelamin</label>
                      <select name="jenis_penumpang_${i}" class="form-control">
                        <option value="true">Laki-laki</option>
                        <option value="false">Perempuan</option>
                      </select>
                    </div>
                  </div>
                </div>`;
              wrap.appendChild(card);
            }
          }

          // ---- Cek tiket ----
          btnSearch?.addEventListener('click', async ()=>{
            searchMsg.textContent='';
            if(!fromSel?.value || !toSel?.value || !goDateS?.value){searchMsg.textContent='Lengkapi asal, tujuan, dan tanggal.';return;}
            ticketsFound=[];ticketsFiltered=[];selectedTicketId=null;occupiedSeats=[];selectedSeats=[];layoutMatrix=[];
            listWrap.innerHTML='<div class="tvl-skeleton mb-2"></div><div class="tvl-skeleton"></div>';
            seatMap.innerHTML=''; seatPickedView.textContent='-'; hiddenTicket.value=''; hiddenDate.value=''; seatsInput.value=''; hidePhotos();
            try{
              const qs=new URLSearchParams({from_route:fromSel.value,to_route:toSel.value,go_date:goDateS.value}).toString();
              const res=await fetch(`{{ route('orders.search') }}?${qs}`,{headers:{'X-Requested-With':'XMLHttpRequest'}});
              const data=await res.json();
              if(!data.ok){
                listWrap.innerHTML='';
                searchMsg.textContent = data.message || 'Tiket tidak tersedia.';
                return;
              }
              ticketsFound=data.tickets||[]; lastSearchToken=token(); canProceedToStep2=true; hiddenDate.value=goDateS.value;
              searchMsg.textContent=`Ditemukan ${ticketsFound.length} tiket. Klik Next untuk memilih.`;
              renderList();
            }catch(e){console.error(e);listWrap.innerHTML='';searchMsg.textContent='Gagal mencari tiket.';}
          });

          // ---- NAV ----
          btnPrev.addEventListener('click',()=>{if(current>1) go(current-1)});
          btnNext.addEventListener('click',async()=>{
            if(current===1){
              if(!canProceedToStep2 || !lastSearchToken){alert('Klik "Cek Tiket" dulu.');return;}
              const j=parseInt(jumlahSel?.value||'1',10); if(j<1){alert('Jumlah penumpang tidak valid.');return;}
              go(2); renderList(); hidePhotos(); seatMap.innerHTML=''; selectedSeats=[]; seatsInput.value=''; seatPickedView.textContent='-'; return;
            }
            if(current===2){
              if(!selectedTicketId){alert('Pilih salah satu tiket.');return;}
              if(!canProceedToStep2 || !lastSearchToken){alert('Silakan cek tiket lagi.');resetSearch('state tidak valid');return;}
              if(selectedToken && selectedToken!==lastSearchToken){alert('Parameter pencarian berubah, cek tiket lagi.');resetSearch('token berubah');return;}
              const j=parseInt(jumlahSel?.value||'1',10);
              if(selectedSeats.length!==j){alert('Jumlah kursi harus sama dengan jumlah penumpang.');return;}
              try{
                const url=`{{ route('orders.availability') }}?`+new URLSearchParams({ticket_id:selectedTicketId,go_date:hiddenDate?.value||goDateS?.value||''}).toString();
                const res=await fetch(url,{headers:{'X-Requested-With':'XMLHttpRequest'}}); const data=await res.json();
                if(!data || data.ok===false){alert(data?.message||'Gagal validasi.');return;}
                const occ=new Set((Array.isArray(data.occupied)?data.occupied:[]).map(String));
                if(selectedSeats.some(s=>occ.has(String(s)))){renderSeatMap();alert('Ada kursi sudah terisi, pilih ulang.');return;}
                buildPassengers(j); go(3);
              }catch(e){console.error(e);alert('Gagal validasi.');}
              return;
            }
            if(current===3){
              // >>>> VALIDASI STEP 3 (alamat, no WA angka, nama penumpang tanpa angka) <<<<
              if (!validateStep3()) return;
              go(4);return;
            }
            if(current===4){
              if(!hiddenTicket.value){alert('Tiket belum dipilih.');go(2);return;}
              if(!seatsInput.value){alert('Kursi belum dipilih.');go(2);return;}
              document.getElementById('wizard-order').submit();
            }
          });

          // Cegah submit kalau step 4 belum valid (metode pembayaran)
          const form = document.getElementById('wizard-order');
          if (form) {
            form.addEventListener('submit', function(e) {
              // Pastikan kita validasi bagian pembayaran
              if (!validateStep4()) {
                e.preventDefault();      // blok submit ke server
                go(4);                   // pastikan tetap di slide 4
              }
            });
          }

          // Tentukan step awal berdasarkan error Laravel (kalau ada)
          let initialStep = 1;
          @php
              $hasPayErrors = $errors->has('method_id') || $errors->has('name_account') || $errors->has('from_account');
              $hasPassengerErrors = $errors->has('alamat_lengkap') || $errors->has('nowhatsapp');
          @endphp

          @if ($hasPayErrors)
            initialStep = 4;
          @elseif ($hasPassengerErrors)
            initialStep = 3;
          @endif

          go(initialStep);

        });
        </script>

      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>
        <a href="https://poliwangi.ac.id/" target="_blank" rel="noopener noreferrer">
            TJ Trans Executive x Poliwangi © <script>document.write(new Date().getFullYear());</script>
        </a>
    </strong> 
    All rights reserved.
</footer>

  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
@endsection
