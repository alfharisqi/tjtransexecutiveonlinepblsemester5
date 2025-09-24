@extends('layouts.main')

@section('front-end')
<x-front-navbar></x-front-navbar>

<div class="hero-wrap js-fullheight" style="background-image: url('images/travel1.png');">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
			<div class="col-md-7 ftco-animate">
				<h1 class="mb-4">Selamat Datang</h1>
				<h1 class="mb-4">TJ TRANS EXECUTIVE</h1>
				<p class="caps">Rasakan kenyamanan kelas Executive dalam setiap perjalanan anda</p>
				<a href="/pesantiket" class="btn btn-primary btn-lg btn-block">Pesan Sekarang!</a>
			</div>
		</div>
	</div>
</div>


<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center pb-4">
			<div class="col-md-12 heading-section text-center ftco-animate">
				<!-- <span class="subheading">Destination</span> -->
				<h2 class="mb-4">Layanan & Fasilitas</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/layanan4.JPG); background-size: cover; background-position: center;">
					</a>
					<div class="text p-4">
						<h3><a>Door to Door Service</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Layanan Antar Jemput Door to Door kami, menjemput Anda langsung dari lokasi yang diinginkan. Baik itu rumah, kantor, hotel, atau bandara, dan mengantar sampai ke tujuan akhir Anda dengan nyaman dan tepat waktu.</p>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/layanan1.JPG); background-size: cover; background-position: center;">
					</a>
					<div class="text p-4">
						<h3><a>Sopir Profesional</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Dengan seragam rapi dan lingkungan kabin yang bersih, Kami memasktikan Sopir dengan pelayanan yang ramah, tepat waktu, dan profesional dalam setiap perjalanan.</p>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/layanan2.JPG); background-size: cover; background-position: center;">
					</a>
					<div class="text p-4">
						<h3><a>Kursi Nyaman</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Setiap armada dilengkapi dengan kursi berlapis kulit sintetis berkualitas tinggi. Desain kursi dirancang untuk memberikan kenyamanan maksimal selama perjalanan jauh maupun dekat.</p>

					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/layanan3.JPG); background-size: cover; background-position: center;">
					</a>
					<div class="text p-4">
						<h3><a>Sandaran Kaki</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Kenyamanan maksimal dengan Sandaran Kaki yang dapat disesuaikan, penumpang dapat merebahkan tubuh dengan nyaman dan rileks selama perjalanan.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="ftco-section testimony-section bg-bottom" style="background-image: url(images/bg_1.jpg);">
	<div class="overlay"></div>
	<div class="container">
		<div class="row justify-content-center pb-4">
			<div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
				<h2 class="mb-4">Ringkasan Ulasan</h2>
			</div>
		</div>
		<div class="row ftco-animate">
			<div class="col-md-12">
				<div class="carousel-testimony owl-carousel">
					<div class="item">
						<div class="testimony-wrap py-4">
							<div class="text">
								<p class="star">
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
								</p>
								<p class="mb-4">Perjalanan saya terasa sangat nyaman dengan Tj Trans Executive. Kursinya empuk, ada sandaran kaki, dan kabin bersih. Saya bisa istirahat dengan tenang sepanjang jalan. Benar-benar seperti naik kendaraan pribadi.
								</p>
								<div class="d-flex align-items-center">
									<div class="user-img" style="background-image: url(images/ulasan1.jpg)"></div>
									<div class="pl-3">
										<p class="name">Muhammad Ridwan</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimony-wrap py-4">
							<div class="text">
								<p class="star">
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
								</p>
								<p class="mb-4">Saya sangat terbantu dengan layanan penjemputan tepat waktu langsung dari kantor. Sopirnya sopan dan profesional, serta sangat membantu dengan barang bawaan saya di bandara. Ini adalah layanan travel yang bisa diandalkan untuk keperluan kerja maupun pribadi.									
								</p>
								<div class="d-flex align-items-center">
									<div class="user-img" style="background-image: url(images/ulasan2.jpg)"></div>
									<div class="pl-3">
										<p class="name">Indah Dewi</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimony-wrap py-4">
							<div class="text">
								<p class="star">
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
								</p>
								<p class="mb-4">Proses pemesanan lewat website Tj Trans Executive sangat mudah dan fleksibel. Saya bisa pilih jadwal dan lokasi jemput tanpa ribet. Antarmukanya simpel, cocok untuk pengguna baru. Sangat memudahkan, apalagi saat bepergian mendadak.</p>
								<div class="d-flex align-items-center">
									<div class="user-img" style="background-image: url(images/ulasan3.jpg)"></div>
									<div class="pl-3">
										<p class="name">Sony Sanjaya</p>
									</div>
								</div>
							</div>
						</div>
					</div>

		
				</div>
			</div>
		</div>
	</div>
</section>



<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url(images/bg_3.jpg);">
	<div class="container">
		<div class="row mb-5">
			<div class="col-md pt-5">
				<div class="ftco-footer-widget pt-md-5 mb-4">
					<h2 class="ftco-heading-2">About</h2>
					<p>TJ Trans Executive berkomitmen untuk memberikan layanan transportasi yang aman, nyaman, dan tepat waktu. Dengan pengalaman bertahun-tahun, kami melayani berbagai kebutuhan perjalanan Anda, mulai dari perjalanan pribadi hingga layanan transportasi korporat. Percayakan perjalanan Anda pada kami, dan nikmati kenyamanan serta kualitas layanan terbaik.</p>
					<ul class="ftco-footer-social list-unstyled float-md-left float-lft">
						<li class="ftco-animate"><a href="" target="#"><span class="fa fa-twitter"></span></a></li>
						<li class="ftco-animate"><a href="" target="#"><span class="fa fa-facebook"></span></a></li>
						<li class="ftco-animate"><a href="" target="#"><span class="fa fa-instagram"></span></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md pt-5 border-left">
				<div class="ftco-footer-widget pt-md-5 mb-4">
					<h2 class="ftco-heading-2">Have a Questions?</h2>
					<div class="block-23 mb-3">
						<ul>
							<li><span class="icon fa fa-map-marker"></span><span class="text">Alamat</span></li>
							<li><a href=""><span class="icon fa fa-whatsapp"></span><span class="text">123 Admin 1
										</span></a></li>
							<li><a href=""><span class="icon fa fa-whatsapp"></span><span class="text">123 Admin 2
										</span></a></li>
							<li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">tjtransexecutive@gmail.com</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">

				<p>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					TJ Trans Executive &copy;
					<script>
						document.write(new Date().getFullYear());
					</script>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
			</div>
		</div>
	</div>
</footer>



<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
		<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
		<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
	</svg></div>
@endsection