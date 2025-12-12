@extends('layouts.front')

@section('front')
<div class="wrapper">

  <!-- Navbar -->
  <x-front-dashboard-navbar />
  <!-- /.Navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="{{ asset('favicon.ico') }}" alt="TJ Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">TJ Trans Executive</span>
    </a>

    <!-- Sidebar Menu -->
    <x-front-sidemenu />
    <!-- /.sidebar-menu -->
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @can('isAdmin')
        <div class="row">
          <!-- Tickets -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Tiket</h3>
                <p>{{ number_format($tickets->count()) }} tiket terdaftar</p>
              </div>
              <div class="icon"><i class="ion ion-bag"></i></div>
              <a href="/tickets" class="small-box-footer">
                Lihat daftar harga tiket <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <!-- Orders -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Pesanan</h3>
                <p>{{ number_format($orders->count()) }} total pesanan</p>
              </div>
              <div class="icon"><i class="ion ion-stats-bars"></i></div>
              <a href="/orders" class="small-box-footer">
                Lihat daftar pesanan <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <!-- Transactions -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Transaksi</h3>
                <p>{{ number_format($transactions->count()) }} menunggu konfirmasi</p>
              </div>
              <div class="icon"><i class="ion ion-person-add"></i></div>
              <a href="/transactions" class="small-box-footer">
                Lihat daftar transaksi <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <!-- Complaints -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Keluhan</h3>
                <p>{{ number_format($complaints->count()) }} belum ditanggapi</p>
              </div>
              <div class="icon"><i class="ion ion-pie-graph"></i></div>
              <a href="/orders" class="small-box-footer">
                Lihat keluhan <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
        @endcan

        @can('isCustomer')
        <div class="row">
          <!-- CTA Order -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Pesan Tiket</h3>
                <p>Mulai pemesanan tiket sekarang</p>
              </div>
              <div class="icon"><i class="ion ion-stats-bars"></i></div>
              <a href="/orders/create" class="small-box-footer">
                Buat Pesanan <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <!-- Tickets -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Tiket</h3>
                <p>{{ number_format($tickets->count()) }} tiket tersedia</p>
              </div>
              <div class="icon"><i class="ion ion-bag"></i></div>
              <a href="/tickets" class="small-box-footer">
                Lihat daftar harga tiket <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <!-- Transactions -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Transaksi</h3>
                <p>{{ number_format($transactions->count()) }} menunggu konfirmasi</p>
              </div>
              <div class="icon"><i class="ion ion-person-add"></i></div>
              <a href="/transactions" class="small-box-footer">
                Lihat transaksimu <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <!-- Complaints -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Keluhan</h3>
                <p>{{ number_format($complaints->count()) }} belum ditanggapi</p>
              </div>
              <div class="icon"><i class="ion ion-pie-graph"></i></div>
              <a href="/orders" class="small-box-footer">
                Lihat keluhan <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
        @endcan

        <!-- HOW TO BUY -->
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-primary" id="howto">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                  <i class="fas fa-ticket-alt"></i> Tata Cara Membeli Tiket
                </h3>
              </div>

              <div class="card-body">
                <div class="row">
                  <!-- Step 1 -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="border rounded p-3 h-100">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary badge-step mr-2">1</span>
                        <strong>Buka menu <a href="/orders/create">Buat Pesanan</a> di sidebar</strong>
                      </div>
                      <p class="mb-0 text-muted">Klik <b>Buat Pesanan</b> pada sidebar kiri.</p>
                    </div>
                  </div>

                  <!-- Step 2 -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="border rounded p-3 h-100">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary badge-step mr-2">2</span>
                        <strong>Pilih asal, tujuan, tanggal & jumlah penumpang</strong>
                      </div>
                      <p class="mb-0 text-muted">Isi form pencarian untuk menampilkan jadwal tersedia.</p>
                    </div>
                  </div>

                  <!-- Step 3 -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="border rounded p-3 h-100">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary badge-step mr-2">3</span>
                        <strong>Pilih tiket & kursi yang tersedia</strong>
                      </div>
                      <p class="mb-0 text-muted">Klik kursi yang kosong; kursi terpesan terkunci otomatis.</p>
                    </div>
                  </div>

                  <!-- Step 4 -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="border rounded p-3 h-100">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary badge-step mr-2">4</span>
                        <strong>Isi data penumpang & titik jemput</strong>
                      </div>
                      <p class="mb-0 text-muted">Lengkapi identitas & lokasi penjemputan.</p>
                    </div>
                  </div>

                  <!-- Step 5 -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="border rounded p-3 h-100">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary badge-step mr-2">5</span>
                        <strong>Pilih metode pembayaran</strong>
                      </div>
                      <p class="mb-0 text-muted">Pilih transfer/VA/dll sesuai preferensi.</p>
                    </div>
                  </div>

                  <!-- Step 6 -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="border rounded p-3 h-100">
                      <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary badge-step mr-2">6</span>
                        <strong>Unggah bukti & tunggu konfirmasi</strong>
                      </div>
                      <p class="mb-0 text-muted">Notifikasi konfirmasi akan dikirim via email.</p>
                    </div>
                  </div>
                </div>

                <div class="alert alert-info mt-2 mb-0">
                  <i class="fas fa-info-circle mr-1"></i>
                  Tips: Pastikan email aktif & nomor telepon dapat dihubungi. Cek folder <b>Spam/Promotions</b> jika belum menerima email.
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.HOW TO BUY -->

        <!-- Placeholder Charts / Cards (tetap bawaan) -->
        <div class="row">
          <section class="col-lg-5 connectedSortable">
            <div class="card bg-gradient-primary"></div>
            <div class="card-footer bg-transparent"></div>
          </section>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>
        <a href="https://poliwangi.ac.id/" target="_blank" rel="noopener noreferrer">
            TJ Trans Executive x Poliwangi © <script>document.write(new Date().getFullYear());</script>
        </a>
    </strong> 
    All rights reserved.
</footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark"></aside>

</div>
<!-- /.wrapper -->

{{-- =================== THEME TWEAK (warna elegan, efek tetap bawaan) =================== --}}
<style>
    
  /* Sidebar: biru elegan (tanpa mengubah efek hover/active bawaan) */
  .main-sidebar.sidebar-dark-primary {
    background: linear-gradient(180deg, #0e2f57 0%, #103e74 60%, #0b2847 100%) !important;
  }
  .main-sidebar .brand-link { background: rgba(255,255,255,.05); color: #e6f0fa !important; }
  .main-sidebar .brand-link:hover { background: rgba(255,255,255,.1); }

  /* Link aktif tetap biru terang */
  .nav-sidebar > .nav-item > .nav-link.active { background-color: #1565c0 !important; color: #fff !important; }

  /* How-to: step badge seragam */
  #howto .badge-step { min-width: 32px; height: 24px; display: inline-flex; align-items: center; justify-content: center; }
  #howto img { cursor: zoom-in; }
</style>

{{-- =================== PAGE SCRIPTS (tetap bawaan AdminLTE) =================== --}}
<script>
  $(function () {
    // Area chart (contoh bawaan)
    var areaChartCanvas = $('#areaChart').get(0)?.getContext('2d');
    if (areaChartCanvas) {
      var areaChartData = {
        labels: ['January','February','March','April','May','June','July'],
        datasets: [
          { label:'Digital Goods', backgroundColor:'rgba(60,141,188,0.9)', borderColor:'rgba(60,141,188,0.8)', pointRadius:false, pointColor:'#3b8bba', pointStrokeColor:'rgba(60,141,188,1)', pointHighlightFill:'#fff', pointHighlightStroke:'rgba(60,141,188,1)', data:[28,48,40,19,86,27,90] },
          { label:'Electronics',  backgroundColor:'rgba(210,214,222,1)',   borderColor:'rgba(210,214,222,1)',   pointRadius:false, pointColor:'rgba(210,214,222,1)', pointStrokeColor:'#c1c7d1', pointHighlightFill:'#fff', pointHighlightStroke:'rgba(220,220,220,1)', data:[65,59,80,81,56,55,40] }
        ]
      };
      var areaChartOptions = { maintainAspectRatio:false, responsive:true, legend:{display:false}, scales:{ xAxes:[{gridLines:{display:false}}], yAxes:[{gridLines:{display:false}}] } };
      new Chart(areaChartCanvas, { type:'line', data:areaChartData, options:areaChartOptions });
    }

    // Komponen lain tetap bawaan (aman jika canvas tidak ada)
    function buildChart(id, type, data, options){ var ctx = $(id).get(0)?.getContext('2d'); if(ctx){ new Chart(ctx,{type,data,options}); } }
    buildChart('#lineChart','line', areaChartData || {}, $.extend(true, {}, {datasetFill:false}, areaChartOptions || {}));

    var donutData = { labels:['Chrome','IE','FireFox','Safari','Opera','Navigator'], datasets:[{ data:[700,500,400,600,300,100], backgroundColor:['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de'] }] };
    buildChart('#donutChart','doughnut', donutData, { maintainAspectRatio:false, responsive:true });
    buildChart('#pieChart','pie', donutData, { maintainAspectRatio:false, responsive:true });

    var barData = areaChartData ? $.extend(true, {}, areaChartData) : {};
    if (barData.datasets){ var t0 = barData.datasets[0], t1 = barData.datasets[1]; barData.datasets[0] = t1; barData.datasets[1] = t0; }
    buildChart('#barChart','bar', barData, { responsive:true, maintainAspectRatio:false, datasetFill:false });
    buildChart('#stackedBarChart','bar', barData, { responsive:true, maintainAspectRatio:false, scales:{xAxes:[{stacked:true}], yAxes:[{stacked:true}] }});
  });
</script>
@endsection
