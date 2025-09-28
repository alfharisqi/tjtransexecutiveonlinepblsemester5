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
                <img src="{{ asset('favicon.ico') }}" alt="TJ Logo"
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    @can('isAdmin')
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>Tiket</h3>
                                        <p>{{ $tickets->count() }} tiket telah terdaftar!</p>
                                        <br>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="/tickets" class="small-box-footer">Klik untuk melihat daftar harga tiket <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>Pesanan</h3>
                                        <p>Terdapat pesanan lebih dari {{ $orders->count() - 1 }}</p>
                                        <br>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Klik untuk melihat daftar pesanan <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>Transaksi</h3>

                                        <p>Terdapat {{ $transactions->count() }} yang belum di konfirmasi/setujui</p>
                                        <br>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="/transactions" class="small-box-footer">Klik untuk melihat daftar transaksi <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>Keluhan</h3>

                                        <p>Terdapat {{ $complaints->count() }} keluhan/obrolan yang belum ditanggapi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="/orders" class="small-box-footer">Klik untuk melihat daftar keluhan <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <!-- /.card-body -->
                        </div>
                    @endcan
                    @can('isCustomer')
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>Pesanan</h3>

                                        <p>Ayo, pesan tiket pesawat mu sekarang!</p>
                                        <br>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="/orders/create" class="small-box-footer">Klik untuk memesan tiket pesawat <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>Tiket</h3>

                                        <p>Terdapat lebih dari {{ $tickets->count() - 1 }} tiket yang dapat kamu pesan sekarang!
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="/tickets" class="small-box-footer">Klik untuk melihat daftar harga tiket <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>Transaksi</h3>
                                        <p>Terdapat {{ $transactions->count() }} transaksi yang belum di konfirmasi/setujui</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="/transactions" class="small-box-footer">Klik untuk melihat daftar transaksimu
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>Keluhan</h3>

                                        <p>Terdapat {{ $complaints->count() }} keluhan/obrolan yang belum ditanggapi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="/orders" class="small-box-footer">Klik untuk melihat daftar keluhan <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <!-- /.card-body -->
                        </div>
                    @endcan
                    <!-- ./col -->
                </div>

                <!-- =================== TATA CARA MEMBELI TIKET =================== -->
                <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary" id="howto">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                        <i class="fas fa-ticket-alt"></i> Tata Cara Membeli Tiket
                        </h3>
                        <div class="card-tools">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                        <!-- Step 1 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-primary mr-2" style="min-width:32px">1</span>
                                <strong>Buka menu <em><a href="/orders/create">Buat Pesanan</a></em> di sidebar</strong>
                            </div>
                            <p class="mb-3 text-muted">Klik menu <b>Buat Pesanan</b> pada sidebar kiri untuk mulai pemesanan.</p>
                            <!-- <a href="#" data-toggle="modal" data-target="#howtoStep1Modal">
                                <img src="{{ asset('images/howto/step1_buat_pesanan.png') }}" alt="Buat Pesanan"
                                    class="img-fluid rounded shadow-sm">
                            </a> -->
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-primary mr-2" style="min-width:32px">2</span>
                                <strong>Pilih asal, tujuan, tanggal & jumlah penumpang</strong>
                            </div>
                            <p class="mb-3 text-muted">Isi form pencarian untuk menampilkan jadwal yang tersedia.</p>
                            <!-- <a href="#" data-toggle="modal" data-target="#howtoStep2Modal">
                                <img src="{{ asset('images/howto/step2_filter.jpg') }}" alt="Pilih rute & tanggal"
                                    class="img-fluid rounded shadow-sm">
                            </a> -->
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-primary mr-2" style="min-width:32px">3</span>
                                <strong>Pilih tiket & kursi yang tersedia</strong>
                            </div>
                            <p class="mb-3 text-muted">Pilih armada/jadwal lalu klik kursi yang masih kosong (kursi terpesan tidak bisa dipilih).</p>
                            <!-- <a href="#" data-toggle="modal" data-target="#howtoStep3Modal">
                                <img src="{{ asset('images/howto/step3_kursi.jpg') }}" alt="Pilih kursi"
                                    class="img-fluid rounded shadow-sm">
                            </a> -->
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-primary mr-2" style="min-width:32px">4</span>
                                <strong>Isi data penumpang & titik jemput</strong>
                            </div>
                            <p class="mb-3 text-muted">Lengkapi identitas penumpang dan lokasi penjemputan agar sopir mudah menemukan Anda.</p>
                            <!-- <a href="#" data-toggle="modal" data-target="#howtoStep4Modal">
                                <img src="{{ asset('images/howto/step4_data_penumpang.jpg') }}" alt="Data penumpang"
                                    class="img-fluid rounded shadow-sm">
                            </a> -->
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-primary mr-2" style="min-width:32px">5</span>
                                <strong>Pilih metode pembayaran</strong>
                            </div>
                            <p class="mb-3 text-muted">Pilih metode pembayaran yang tersedia (transfer/virtual account/dll).</p>
                            <!-- <a href="#" data-toggle="modal" data-target="#howtoStep5Modal">
                                <img src="{{ asset('images/howto/step5_pembayaran.jpg') }}" alt="Pilih pembayaran"
                                    class="img-fluid rounded shadow-sm">
                            </a> -->
                            </div>
                        </div>

                        <!-- Step 6 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-primary mr-2" style="min-width:32px">6</span>
                                <strong>Unggah bukti & tunggu konfirmasi</strong>
                            </div>
                            <p class="mb-3 text-muted">Unggah bukti pembayaran. Notifikasi konfirmasi akan dikirim melalui email.</p>
                            <!-- <a href="#" data-toggle="modal" data-target="#howtoStep6Modal">
                                <img src="{{ asset('images/howto/step6_upload_bukti.jpg') }}" alt="Unggah pembayaran"
                                    class="img-fluid rounded shadow-sm">
                            </a> -->
                            </div>
                        </div>

                        </div>

                        <div class="alert alert-info mt-2 mb-0">
                        <i class="fas fa-info-circle mr-1"></i>
                        Tips: Siapkan email aktif & nomor yang bisa dihubungi. Cek folder <b>Spam/Promotions</b> jika tidak menerima email.
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- =================== /TATA CARA MEMBELI TIKET =================== -->

                <!-- =================== MODALS (PREVIEW FOTO SETIAP LANGKAH) =================== -->
                <!-- Step 1 Modal -->
                <div class="modal fade" id="howtoStep1Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title">Langkah 1 — Buka menu Buat Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                    </div>
                    <!-- <div class="modal-body p-2">
                        <img src="{{ asset('images/howto/step1_buat_pesanan.jpg') }}" class="img-fluid rounded w-100" alt="">
                    </div> -->
                    </div>
                </div>
                </div>

                <!-- Step 2 Modal -->
                <div class="modal fade" id="howtoStep2Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title">Langkah 2 — Pilih asal, tujuan, tanggal & jumlah penumpang</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <!-- <div class="modal-body p-2">
                        <img src="{{ asset('images/howto/step2_filter.jpg') }}" class="img-fluid rounded w-100" alt="">
                    </div> -->
                    </div>
                </div>
                </div>

                <!-- Step 3 Modal -->
                <div class="modal fade" id="howtoStep3Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title">Langkah 3 — Pilih tiket & kursi</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <!-- <div class="modal-body p-2">
                        <img src="{{ asset('images/howto/step3_kursi.jpg') }}" class="img-fluid rounded w-100" alt="">
                    </div> -->
                    </div>
                </div>
                </div>

                <!-- Step 4 Modal -->
                <div class="modal fade" id="howtoStep4Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title">Langkah 4 — Isi data penumpang & titik jemput</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <!-- <div class="modal-body p-2">
                        <img src="{{ asset('images/howto/step4_data_penumpang.jpg') }}" class="img-fluid rounded w-100" alt="">
                    </div> -->
                    </div>
                </div>
                </div>

                <!-- Step 5 Modal -->
                <div class="modal fade" id="howtoStep5Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title">Langkah 5 — Pilih metode pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <!-- <div class="modal-body p-2">
                        <img src="{{ asset('images/howto/step5_pembayaran.jpg') }}" class="img-fluid rounded w-100" alt="">
                    </div> -->
                    </div>
                </div>
                </div>

                <!-- Step 6 Modal -->
                <div class="modal fade" id="howtoStep6Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title">Langkah 6 — Unggah bukti & tunggu konfirmasi</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <!-- <div class="modal-body p-2">
                        <img src="{{ asset('images/howto/step6_upload_bukti.jpg') }}" class="img-fluid rounded w-100" alt="">
                    </div> -->
                    </div>
                </div>
                </div>
                <!-- =================== /MODALS =================== -->

                <!-- Sedikit styling opsional -->
                <style>
                #howto .badge { font-size: 0.9rem; }
                #howto img { cursor: zoom-in; }
                </style>

                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">

                        <!-- Map card -->
                        <div class="card bg-gradient-primary">
                            <!-- /.card-body-->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-transparent">
                            <div class="row">
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
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

    <!-- Page specific script -->
    <script>
        $(function() {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

            var areaChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                        label: 'Digital Goods',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [28, 48, 40, 19, 86, 27, 90]
                    },
                    {
                        label: 'Electronics',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [65, 59, 80, 81, 56, 55, 40]
                    },
                ]
            }

            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            }

            // This will get the first returned node in the jQuery collection.
            new Chart(areaChartCanvas, {
                type: 'line',
                data: areaChartData,
                options: areaChartOptions
            })

            //-------------
            //- LINE CHART -
            //--------------
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = $.extend(true, {}, areaChartOptions)
            var lineChartData = $.extend(true, {}, areaChartData)
            lineChartData.datasets[0].fill = false;
            lineChartData.datasets[1].fill = false;
            lineChartOptions.datasetFill = false

            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })

            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Chrome',
                    'IE',
                    'FireFox',
                    'Safari',
                    'Opera',
                    'Navigator',
                ],
                datasets: [{
                    data: [700, 500, 400, 600, 300, 100],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData = donutData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            var stackedBarChartData = $.extend(true, {}, barChartData)

            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
    </script>
@endsection
