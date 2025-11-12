@extends('layouts.main')

@section('front-end')

<x-front-navbar></x-front-navbar>

{{-- ====== HERO ====== --}}
<div class="hero-wrap js-fullheight relative" style="background-image: url('{{ asset('images/travel1.png') }}');">
  <div class="overlay" style="background: linear-gradient(180deg, rgba(0,0,0,.45), rgba(0,0,0,.25));"></div>
  <div class="container h-100">
    <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
      <div class="col-md-8 col-lg-7 ftco-animate">
        <h1 class="mb-2 fw-bold text-white" style="letter-spacing:.5px">Selamat Datang</h1>
        <h1 class="mb-3 fw-bold text-white">TJ TRANS EXECUTIVE</h1>
        <p class="caps text-white-50 mb-4">Rasakan kenyamanan kelas Executive dalam setiap perjalanan anda</p>
        <a href="{{ url('/orders/create') }}" class="btn btn-primary btn-lg px-4 py-3 shadow-sm w-100 w-md-auto" aria-label="Pesan tiket sekarang">
          Pesan Sekarang!
        </a>
      </div>
    </div>
  </div>
</div>

{{-- ====== LAYANAN & FASILITAS ====== --}}
<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center pb-4">
      <div class="col-md-12 heading-section text-center ftco-animate">
        <h2 class="mb-2">Layanan &amp; Fasilitas</h2>
        <p class="text-muted mb-0">Kualitas premium yang konsisten di setiap perjalanan</p>
      </div>
    </div>

    <div class="row g-4">
      {{-- Item 1 --}}
      <div class="col-sm-12 col-md-6 col-lg-4 ftco-animate">
        <div class="project-wrap h-100 shadow-sm rounded-3 overflow-hidden border-0">
          <a class="img d-block" role="img" aria-label="Door to Door Service"
             style="background-image:url('{{ asset('images/layanan4.JPG') }}'); background-size:cover; background-position:center; padding-top:62%;">
          </a>
          <div class="text p-4">
            <h3 class="mb-2"><a>Door to Door Service</a></h3>
            <p class="location m-0">
              <span class="fa fa-map-marker me-2"></span>
              Layanan antar jemput dari lokasi pilihan Anda (rumah, kantor, hotel, bandara) hingga tujuan akhir, nyaman dan tepat waktu.
            </p>
          </div>
        </div>
      </div>

      {{-- Item 2 --}}
      <div class="col-sm-12 col-md-6 col-lg-4 ftco-animate">
        <div class="project-wrap h-100 shadow-sm rounded-3 overflow-hidden border-0">
          <a class="img d-block" role="img" aria-label="Sopir Profesional"
             style="background-image:url('{{ asset('images/layanan1.JPG') }}'); background-size:cover; background-position:center; padding-top:62%;">
          </a>
          <div class="text p-4">
            <h3 class="mb-2"><a>Sopir Profesional</a></h3>
            <p class="location m-0">
              <span class="fa fa-map-marker me-2"></span>
              Sopir berseragam, ramah, tepat waktu, dan profesional. Kabin bersih untuk pengalaman berkendara yang menyenangkan.
            </p>
          </div>
        </div>
      </div>

      {{-- Item 3 --}}
      <div class="col-sm-12 col-md-6 col-lg-4 ftco-animate">
        <div class="project-wrap h-100 shadow-sm rounded-3 overflow-hidden border-0">
          <a class="img d-block" role="img" aria-label="Kursi Nyaman"
             style="background-image:url('{{ asset('images/layanan2.JPG') }}'); background-size:cover; background-position:center; padding-top:62%;">
          </a>
          <div class="text p-4">
            <h3 class="mb-2"><a>Kursi Nyaman</a></h3>
            <p class="location m-0">
              <span class="fa fa-map-marker me-2"></span>
              Kursi berlapis kulit sintetis berkualitas dengan desain ergonomis untuk perjalanan jauh maupun dekat.
            </p>
          </div>
        </div>
      </div>

      {{-- Item 4 --}}
      <div class="col-sm-12 col-md-6 col-lg-4 ftco-animate">
        <div class="project-wrap h-100 shadow-sm rounded-3 overflow-hidden border-0">
          <a class="img d-block" role="img" aria-label="Sandaran Kaki"
             style="background-image:url('{{ asset('images/layanan3.JPG') }}'); background-size:cover; background-position:center; padding-top:62%;">
          </a>
          <div class="text p-4">
            <h3 class="mb-2"><a>Sandaran Kaki</a></h3>
            <p class="location m-0">
              <span class="fa fa-map-marker me-2"></span>
              Sandaran kaki yang dapat disesuaikan agar tubuh lebih rileks dan nyaman sepanjang perjalanan.
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- ====== TESTIMONI ====== --}}
<section class="ftco-section testimony-section bg-bottom position-relative" style="background-image: url('{{ asset('images/bg_1.jpg') }}');">
  <div class="overlay" style="background: rgba(0,0,0,.55);"></div>
  <div class="container position-relative">
    <div class="row justify-content-center pb-4">
      <div class="col-md-8 text-center heading-section heading-section-white ftco-animate">
        <h2 class="mb-2">Ringkasan Ulasan</h2>
        <p class="text-white-50 mb-0">Apa kata pelanggan tentang kami</p>
      </div>
    </div>

    <div class="row ftco-animate">
      <div class="col-md-12">
        <div class="carousel-testimony owl-carousel">

          {{-- Review 1 --}}
          <div class="item">
            <div class="testimony-wrap py-4 px-3">
              <div class="text">
                <p class="star" aria-label="Rating 5 dari 5">
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                </p>
                <p class="mb-4">
                  Perjalanan saya terasa sangat nyaman dengan TJ Trans Executive. Kursinya empuk, ada sandaran kaki, dan kabin bersih. Benar-benar seperti naik kendaraan pribadi.
                </p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image:url('{{ asset('images/ulasan1.jpg') }}')"></div>
                  <div class="ps-3">
                    <p class="name mb-0">Muhammad Ridwan</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Review 2 --}}
          <div class="item">
            <div class="testimony-wrap py-4 px-3">
              <div class="text">
                <p class="star" aria-label="Rating 5 dari 5">
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                </p>
                <p class="mb-4">
                  Penjemputan tepat waktu dari kantor. Sopir sopan dan membantu barang di bandara. Cocok untuk kebutuhan kerja maupun pribadi.
                </p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image:url('{{ asset('images/ulasan2.jpg') }}')"></div>
                  <div class="ps-3">
                    <p class="name mb-0">Indah Dewi</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Review 3 --}}
          <div class="item">
            <div class="testimony-wrap py-4 px-3">
              <div class="text">
                <p class="star" aria-label="Rating 5 dari 5">
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                </p>
                <p class="mb-4">
                  Pemesanan di website sangat mudah. Pilih jadwal dan lokasi jemput tanpa ribet. Antarmukanya simpel dan jelas.
                </p>
                <div class="d-flex align-items-center">
                  <div class="user-img" style="background-image:url('{{ asset('images/ulasan3.jpg') }}')"></div>
                  <div class="ps-3">
                    <p class="name mb-0">Sony Sanjaya</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div> {{-- /.carousel-testimony --}}
      </div>
    </div>
  </div>
</section>

{{-- ====== FOOTER ====== --}}
<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url('{{ asset('images/bg_3.jpg') }}');">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md pt-5">
        <div class="ftco-footer-widget pt-md-5 mb-4">
          <h2 class="ftco-heading-2">About</h2>
          <p class="mb-3">
            TJ Trans Executive berkomitmen menghadirkan layanan transportasi yang aman, nyaman, dan tepat waktu untuk perjalanan pribadi hingga korporat.
          </p>
          <ul class="ftco-footer-social list-unstyled d-flex gap-3">
            <li class="ftco-animate"><a href="#" aria-label="Twitter"><span class="fa fa-twitter"></span></a></li>
            <li class="ftco-animate"><a href="#" aria-label="Facebook"><span class="fa fa-facebook"></span></a></li>
            <li class="ftco-animate"><a href="#" aria-label="Instagram"><span class="fa fa-instagram"></span></a></li>
          </ul>
        </div>
      </div>

      <div class="col-md pt-5 border-left">
        <div class="ftco-footer-widget pt-md-5 mb-4">
          <h2 class="ftco-heading-2">Have a Questions?</h2>
          <div class="block-23 mb-3">
            <ul class="list-unstyled m-0">
              <li class="mb-2">
                <span class="icon fa fa-map-marker me-2"></span>
                <span class="text">Jl Meranti No. 71, Kabupaten Barito Utara, Kalimantan Tengah.</span>
              </li>
              <li class="mb-2">
                <a href="#">
                  <span class="icon fa fa-whatsapp me-2"></span>
                  <span class="text">123 Admin 1</span>
                </a>
              </li>
              <li class="mb-2">
                <a href="#">
                  <span class="icon fa fa-whatsapp me-2"></span>
                  <span class="text">123 Admin 2</span>
                </a>
              </li>
              <li>
                <a href="mailto:tjtransexecutive@gmail.com">
                  <span class="icon fa fa-paper-plane me-2"></span>
                  <span class="text">tjtransexecutive@gmail.com</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12 text-center">
        <p class="m-0"><a href="https://poliwangi.ac.id/">TJ Trans Executive x Poliwangi &copy; <script>document.write(new Date().getFullYear());</script></a>
          
        </p>
      </div>
    </div>
  </div>
</footer>

{{-- ====== LOADER ====== --}}
<div id="ftco-loader" class="show fullscreen">
  <svg class="circular" width="48px" height="48px" aria-hidden="true">
    <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"></circle>
    <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"></circle>
  </svg>
</div>

{{-- ====== MICRO-TWEAKS: hanya kosmetik, tak mengubah fungsi ====== --}}
<style>
  .fw-bold { font-weight:700; }
  @media (max-width: 576px){
    .hero-wrap .btn{ font-size:1rem; padding:.75rem 1rem; }
    .heading-section h2{ font-size:1.5rem; }
  }
  .project-wrap{ transition: transform .2s ease, box-shadow .2s ease; }
  .project-wrap:hover{ transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.08); }
  .testimony-wrap{ background: rgba(255,255,255,.95); border-radius: 14px; }
  .user-img{ width:48px; height:48px; border-radius:50%; background-size:cover; background-position:center; flex:0 0 48px; }
</style>

@endsection
