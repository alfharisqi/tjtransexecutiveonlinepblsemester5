{{-- resources/views/dashboard/finance/index.blade.php --}}
@extends('layouts.front')

@section('front')
<div class="wrapper">
    <!-- Navbar -->
    <x-front-dashboard-navbar></x-front-dashboard-navbar>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/dashboard" class="brand-link">
            <img src="{{ asset('favicon.ico') }}" alt="TJ Trans Executive Logo"
                 class="brand-image img-circle elevation-3" style="opacity:.8">
            <span class="brand-text font-weight-light">TJ Trans Executive</span>
        </a>
        <x-front-sidemenu></x-front-sidemenu>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Ringkasan Keuangan</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Keuangan</li>
                        </ol>
                    </div>
                </div>

                {{-- Alerts --}}
                @if (session('ok'))
                  <div class="alert alert-success mt-2">{{ session('ok') }}</div>
                @endif
                @if ($errors->any())
                  <div class="alert alert-danger mt-2">
                    <ul class="mb-0">
                      @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                  </div>
                @endif
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                {{-- FILTER Periode: Harian / Bulanan / Tahunan --}}
                <form method="get" class="mb-3 row g-2 align-items-center">
                    <div class="col-auto">
                        <select name="mode" id="mode" class="form-control">
                            <option value="day"   {{ $mode==='day'   ? 'selected' : '' }}>Harian</option>
                            <option value="month" {{ $mode==='month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year"  {{ $mode==='year'  ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>

                    {{-- Harian --}}
                    <div class="col-auto mode-field mode-day" style="display:none;">
                        <input type="date" name="date"
                               value="{{ ($valDate ?? now())->format('Y-m-d') }}"
                               class="form-control">
                    </div>

                    {{-- Bulanan --}}
                    <div class="col-auto mode-field mode-month" style="display:none;">
                        <input type="month" name="month"
                               value="{{ $valMonth ?? now()->format('Y-m') }}"
                               class="form-control">
                    </div>

                    {{-- Tahunan --}}
                    <div class="col-auto mode-field mode-year" style="display:none;">
                        <input type="number" name="year" min="2000" max="2100"
                               value={{ $valYear ?? now()->year }}
                               class="form-control" placeholder="Tahun">
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-primary">Filter</button>
                    </div>
                </form>

                <script>
                (function(){
                  const modeSel = document.getElementById('mode');
                  function show(m){
                    document.querySelectorAll('.mode-field').forEach(el=>el.style.display='none');
                    document.querySelectorAll('.mode-'+m).forEach(el=>el.style.display='block');
                  }
                  show(modeSel.value);
                  modeSel.addEventListener('change', e=>show(e.target.value));
                })();
                </script>

                {{-- Cards summary --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card"><div class="card-body">
                            <div class="text-muted">Pendapatan Kotor</div>
                            <h3>Rp {{ number_format($gross,0,',','.') }}</h3>
                        </div></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card"><div class="card-body">
                            <div class="text-muted">Total Biaya</div>
                            <h3 class="text-danger">Rp {{ number_format($expense,0,',','.') }}</h3>
                        </div></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card"><div class="card-body">
                            <div class="text-muted">Laba Bersih</div>
                            <h3 class="{{ $net >= 0 ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($net,0,',','.') }}
                            </h3>
                        </div></div>
                    </div>
                </div>
                {{-- ===== Grafik Keuangan (pilih jenis & sumber data) ===== --}}
<div class="card mb-4">
  <div class="card-header d-flex flex-wrap align-items-center">
    <h3 class="card-title mb-2 mb-sm-0">Grafik Keuangan</h3>
    <div class="ml-sm-auto d-flex flex-wrap" style="gap:.5rem;">
      <select id="chartType" class="form-control form-control-sm">
        <option value="line">Line</option>
        <option value="bar" selected>Bar</option>
        <option value="pie">Pie</option>
        <option value="doughnut">Donut</option>
      </select>
      <select id="chartSource" class="form-control form-control-sm">
        <option value="gross">Harian: Pendapatan Kotor</option>
        <option value="expense">Harian: Total Biaya</option>
        <option value="net" selected>Harian: Laba Bersih</option>
        <option value="gross_expense">Harian: Kotor vs Biaya</option>
        <option value="ticket_net">Per Tiket: Laba Bersih</option>
      </select>
    </div>
  </div>
  <div class="card-body">
    <canvas id="financeChart" style="height:300px"></canvas>
    <div id="chartEmpty" class="text-center text-muted mt-2" style="display:none;">
      Tidak ada data untuk ditampilkan.
    </div>
  </div>
</div>

{{-- ====== Script Chart.js (CDN) ====== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
(function(){
  const dailyLabelsRaw  = @json($daily->pluck('d'));
  const dailyGrossRaw   = @json($daily->pluck('gross'));
  const dailyExpenseRaw = @json($daily->pluck('expense'));
  const dailyNetRaw     = @json($daily->pluck('net'));
  const ticketIdsRaw    = @json($perTicket->pluck('id'));
  const ticketNetRaw    = @json($perTicket->pluck('net'));

  const toNum = x => Number(x ?? 0);
  const fmtDate = s => {
    if (!s) return '';
    const [y,m,d] = s.split('-');
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    return `${d} ${months[Number(m)-1]} ${y}`;
  };

  const dailyLabels  = (dailyLabelsRaw || []).map(fmtDate);
  const dailyGross   = (dailyGrossRaw || []).map(toNum);
  const dailyExpense = (dailyExpenseRaw || []).map(toNum);
  const dailyNet     = (dailyNetRaw || []).map(toNum);
  const ticketLabels = (ticketIdsRaw || []).map(id => `#${id}`);
  const ticketNet    = (ticketNetRaw || []).map(toNum);

  const ctx = document.getElementById('financeChart')?.getContext('2d');
  const emptyEl = document.getElementById('chartEmpty');
  if (!ctx) return;

  // palet warna lembut & konsisten
  const colors = {
    gross:   { bg: 'rgba(54, 162, 235, 0.4)', border: 'rgba(54, 162, 235, 1)' },   // biru
    expense: { bg: 'rgba(255, 99, 132, 0.4)', border: 'rgba(255, 99, 132, 1)' },   // merah
    net:     { bg: 'rgba(75, 192, 192, 0.4)', border: 'rgba(75, 192, 192, 1)' },   // hijau kebiruan
    ticket:  { bg: 'rgba(255, 206, 86, 0.4)', border: 'rgba(255, 206, 86, 1)' }    // kuning
  };

  function mkDataset(label, data, colorKey, type){
    const c = colors[colorKey] || colors.net;
    return {
      label, data,
      backgroundColor: c.bg,
      borderColor: c.border,
      borderWidth: 2,
      tension: (type === 'line') ? 0.25 : 0.1
    };
  }

  function build(source, type){
    let labels = [], datasets = [];

    if (source === 'gross')
      datasets = [ mkDataset('Pendapatan Kotor', dailyGross, 'gross', type) ], labels = dailyLabels;
    else if (source === 'expense')
      datasets = [ mkDataset('Total Biaya', dailyExpense, 'expense', type) ], labels = dailyLabels;
    else if (source === 'net')
      datasets = [ mkDataset('Laba Bersih', dailyNet, 'net', type) ], labels = dailyLabels;
    else if (source === 'gross_expense')
      datasets = [
        mkDataset('Pendapatan Kotor', dailyGross, 'gross', type),
        mkDataset('Total Biaya', dailyExpense, 'expense', type)
      ], labels = dailyLabels;
    else if (source === 'ticket_net')
      datasets = [ mkDataset('Laba Bersih per Tiket', ticketNet, 'ticket', type) ], labels = ticketLabels;

    // jika tipe pie/donut, pakai palet warna bervariasi untuk tiap slice
    if ((type === 'pie' || type === 'doughnut') && datasets.length === 1) {
      const palette = [
        '#36A2EB','#FF6384','#FFCE56','#4BC0C0','#9966FF','#FF9F40','#A1DE93','#F6C90E'
      ];
      datasets[0].backgroundColor = palette.slice(0, datasets[0].data.length);
      datasets[0].borderColor = '#fff';
      datasets[0].borderWidth = 2;
    }

    return { labels, datasets };
  }

  let chartType = document.getElementById('chartType').value;
  let chartSource = document.getElementById('chartSource').value;
  let chart;

  function render(){
    const {labels, datasets} = build(chartSource, chartType);
    if (!labels.length || !datasets[0].data.length) {
      emptyEl.style.display = 'block';
      if (chart) chart.destroy();
      return;
    }
    emptyEl.style.display = 'none';
    if (chart) chart.destroy();

    chart = new Chart(ctx, {
      type: chartType,
      data: { labels, datasets },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true, position: 'top' },
          tooltip: { mode: 'index', intersect: false }
        },
        scales: (chartType === 'pie' || chartType === 'doughnut') ? {} : {
          y: {
            beginAtZero: true,
            ticks: { callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) }
          },
          x: { ticks: { autoSkip: true, maxRotation: 0 } }
        }
      }
    });
  }

  render();
  document.getElementById('chartType').addEventListener('change', e=>{ chartType=e.target.value; render(); });
  document.getElementById('chartSource').addEventListener('change', e=>{ chartSource=e.target.value; render(); });
})();
</script>



                {{-- Form tambah biaya --}}
                <h5>Tambah Biaya</h5>
                <form method="post" action="{{ route('finance.expense.store') }}" class="row g-2 mb-4" id="expense-form">
                  @csrf
                  <div class="col-md-2">
                    <input type="date" name="date" class="form-control" required>
                  </div>

                  <div class="col-md-2">
                    <select name="ticket_id" class="form-control">
                      <option value="">— Biaya Umum (tanpa tiket) —</option>
                      @foreach($tickets as $t)
                        <option value="{{ $t->id }}">Tiket #{{ $t->id }}</option>
                      @endforeach
                    </select>
                  </div>

                  {{-- Preset Biaya --}}
                  <div class="col-md-3 d-flex" style="gap:.5rem;">
                    <select name="preset_id" id="preset_id" class="form-control">
                      <option value="">— Pilih Preset Biaya —</option>
                      @foreach($presets as $p)
                        <option value="{{ $p->id }}"
                                data-name="{{ $p->name }}"
                                data-amount="{{ (int) $p->amount }}">
                          {{ $p->name }} — Rp {{ number_format($p->amount,0,',','.') }}
                        </option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modal-add-preset">+</button>
                  </div>

                  <div class="col-md-2">
                    <input type="text" name="category" id="category" class="form-control" placeholder="Kategori">
                  </div>

                  <div class="col-md-2">
                    <input type="number" name="amount" id="amount" class="form-control" placeholder="Nominal">
                  </div>

                  <div class="col-md-1">
                    <button class="btn btn-success w-100">Simpan</button>
                  </div>

                  <div class="col-12 mt-1">
                    <button type="button" id="clearPreset" class="btn btn-link p-0">Reset preset</button>
                  </div>
                </form>

                {{-- Modal Tambah Preset (DI LUAR form lain) --}}
                <div class="modal fade" id="modal-add-preset" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <form method="post" action="{{ route('expense_presets.store') }}" class="modal-content">
                      @csrf
                      <div class="modal-header">
                        <h5 class="modal-title">Tambah Preset Biaya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label>Nama Preset</label>
                          <input type="text" name="name" class="form-control" placeholder="cth: Oli Mobil Hiace" required>
                        </div>
                        <div class="form-group">
                          <label>Nominal (Rp)</label>
                          <input type="number" name="amount" class="form-control" placeholder="cth: 250000" required>
                        </div>
                        <div class="form-group">
                          <label>Jenis Kendaraan (opsional)</label>
                          <input type="text" name="vehicle_type" class="form-control" placeholder="cth: HiAce">
                        </div>
                        <div class="form-group form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                        <label for="is_active" class="form-check-label">Aktif</label>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button>
                        <button class="btn btn-primary">Simpan Preset</button>
                      </div>
                    </form>
                  </div>
                </div>

                {{-- Autofill dari preset --}}
                <script>
                (function(){
                  const presetSel = document.getElementById('preset_id');
                  const category  = document.getElementById('category');
                  const amount    = document.getElementById('amount');
                  const clearBtn  = document.getElementById('clearPreset');

                  function applyPreset(){
                    const opt = presetSel.options[presetSel.selectedIndex];
                    if (!opt || !opt.value) return;
                    const name    = opt.getAttribute('data-name') || '';
                    const nominal = opt.getAttribute('data-amount') || '';

                    if (!category.value) category.value = name;
                    if (!amount.value)   amount.value   = nominal;
                  }

                  presetSel.addEventListener('change', applyPreset);
                  clearBtn.addEventListener('click', function(){
                    presetSel.value = '';
                    category.value  = '';
                    amount.value    = '';
                  });
                })();
                </script>
 
                {{-- Rekap harian --}}
                <h5>Rekap Harian</h5>
                <table class="table table-sm">
                    <thead><tr><th>Tanggal</th><th>Kotor</th><th>Biaya</th><th>Bersih</th></tr></thead>
                    <tbody>
                    @foreach($daily as $r)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($r->d)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($r->gross,0,',','.') }}</td>
                            <td>Rp {{ number_format($r->expense,0,',','.') }}</td>
                            <td>Rp {{ number_format($r->net,0,',','.') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{-- === PER TIKET: REKAP + BIAYA (default collapsed, gaya tabel ringkas) === --}}
                @foreach($perTicket as $t)
                <div class="card collapsed-card mb-2"><!-- <- default minimized -->
                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title mb-0">Tiket #{{ $t->id }}</h3>

                    <div class="d-flex align-items-center" style="gap:.75rem;">
                        {{-- ringkas info di header --}}
                        <small class="text-muted">
                        Pendapatan: Rp {{ number_format($t->total_income,0,',','.') }} ·
                        Biaya: Rp {{ number_format($t->expense_total,0,',','.') }} ·
                        Laba:
                        <span class="{{ $t->net >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($t->net,0,',','.') }}
                        </span>
                        </small>

                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimize/Expand">
                        <i class="fas fa-plus"></i> {{-- akan jadi minus saat terbuka --}}
                        </button>
                    </div>
                    </div>

                    <div class="card-body p-2"><!-- body disembunyikan saat collapsed -->
                    {{-- Rekap singkat --}}
                    <table class="table table-bordered table-sm mb-2">
                        <thead>
                        <tr>
                            <th class="w-25">Pendapatan (Rp)</th>
                            <th class="w-15">Kursi Terjual</th>
                            <th class="w-15">Orderan yang terbayar</th>
                            <th class="w-20">Biaya (Rp)</th>
                            <th class="w-25">Laba (Rp)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Rp {{ number_format($t->total_income, 0, ',', '.') }}</td>
                            <td>{{ $t->seats_sold }}</td>
                            <td>{{ $t->paid_orders }}</td>
                            <td>Rp {{ number_format($t->expense_total, 0, ',', '.') }}</td>
                            <td class="{{ $t->net >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($t->net, 0, ',', '.') }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    {{-- Biaya untuk tiket ini --}}
                    @php $rows = $expenses->where('ticket_id', $t->id); @endphp
                    <table class="table table-striped table-sm mb-0">
                        <thead>
                        <tr>
                            <th style="width: 140px;">Tanggal</th>
                            <th>Kategori</th>
                            <th style="width: 160px;">Nominal</th>
                            <th>Catatan</th>
                            <th style="width:80px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rows as $e)
                            <tr>
                            <td>{{ $e->date->format('d M Y') }}</td>
                            <td>{{ $e->category }}</td>
                            <td>Rp {{ number_format($e->amount,0,',','.') }}</td>
                            <td>{{ $e->note }}</td>
                            <td>
                                <form method="post" action="{{ route('finance.expense.destroy', $e) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                            </tr>
                        @empty
                            <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada biaya untuk tiket ini.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    </div>

                    <div class="card-footer text-right py-2">
                    <strong>Laba Bersih Tiket #{{ $t->id }}:</strong>
                    <span class="{{ $t->net >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp {{ number_format($t->net, 0, ',', '.') }}
                    </span>
                    </div>
                </div>
                @endforeach

                {{-- ==== Biaya Umum (tanpa tiket) - juga default collapsed ==== --}}
                @php $general = $expenses->where('ticket_id', null); @endphp
                @if($general->count())
                <div class="card collapsed-card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title mb-0">Biaya Umum (tanpa tiket)</h3>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                    </div>
                    <div class="card-body p-2">
                    <table class="table table-striped table-sm mb-0">
                        <thead>
                        <tr>
                            <th style="width: 140px;">Tanggal</th>
                            <th>Kategori</th>
                            <th style="width: 160px;">Nominal</th>
                            <th>Catatan</th>
                            <th style="width:80px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($general as $e)
                            <tr>
                            <td>{{ $e->date->format('d M Y') }}</td>
                            <td>{{ $e->category }}</td>
                            <td>Rp {{ number_format($e->amount,0,',','.') }}</td>
                            <td>{{ $e->note }}</td>
                            <td>
                                <form method="post" action="{{ route('finance.expense.destroy', $e) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                @endif


            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong><a href="https://poliwangi.ac.id/">TJ Trans Executive x Poliwangi &copy; <script>document.write(new Date().getFullYear());</script></a></strong> All rights reserved.
    </footer>
</div>
@endsection
