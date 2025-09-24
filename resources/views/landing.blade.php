@extends('layouts.main')

@section('front-end')
<x-front-navbar></x-front-navbar>

<div class="hero-wrap js-fullheight" style="background-image: url('images/train1.jpg');">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
			<div class="col-md-7 ftco-animate">
				<h1 class="mb-4">Selamat Datang di Sonic</h1>
				<p class="caps">Aplikasi berbasis website untuk jasa pemesanan tiket Kereta</p>
				<a href="/orders/create" class="btn btn-primary">Pesan Sekarang!</a>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center pb-4">
			<div class="col-md-12 heading-section text-center ftco-animate">
				<span class="subheading">Destination</span>
				<h2 class="mb-4">Top Destination</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/destinasi_1.jpeg);">
					</a>
					<div class="text p-4">
						<h3><a>Medan (Sumatera Utara)</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Medan adalah ibu kota provinsi Sumatera Utara dan merupakan pusat ekonomi serta transportasi utama di wilayah tersebut. Kota ini terhubung dengan beberapa rute kereta api, termasuk Medan – Kisaran – Rantau Prapat dan Medan – Tebing Tinggi – Siantar, serta jalur ke pelabuhan Belawan.</p>
					</div>
				</div>
			</div>
			<div class="col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/destinasi_7.jpeg);">
					</a>
					<div class="text p-4">
						<h3><a>Padang (Sumatera Barat)</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> CPadang, ibu kota provinsi Sumatera Barat, adalah kota penting yang terhubung melalui jalur kereta api Padang – Pariaman – Naras dan jalur sejarah ke Bukittinggi dan Sawahlunto. Kota ini juga menjadi destinasi wisata populer.</p>

					</div>
				</div>
			</div>
			<div class="col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/destinasi_10.jpeg);">
					</a>
					<div class="text p-4">
						<h3><a>Palembang (Sumatera Selatan)</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Palembang adalah ibu kota provinsi Sumatera Selatan dan merupakan salah satu kota terbesar di Sumatera. Jalur kereta api yang menghubungkan kota ini termasuk Palembang – Prabumulih – Muara Enim – Lubuk Linggau dan Kertapati – Panjang (Lampung).</p>

					</div>
				</div>
			</div>

			<div class="col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/destinasi_8.jpeg);">
					</a>
					<div class="text p-4">
						<h3><a>Pariaman (Sumatera Barat)</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Pariaman adalah kota yang terletak di jalur kereta api Padang – Pariaman – Naras. Kota ini dikenal sebagai destinasi wisata pantai dan budaya di Sumatera Barat.</p>

					</div>
				</div>
			</div>
			<div class="col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/destinasi_3.jpeg);">
					</a>
					<div class="text p-4">
						<h3><a>Rantau Prapat (Sumatera Utara)</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Rantau Prapat adalah kota penting di jalur kereta api Medan – Kisaran – Rantau Prapat. Kota ini sering dikunjungi untuk berbagai keperluan bisnis dan perjalanan.</p>

					</div>
				</div>
			</div>
			<div class="col-md-4 ftco-animate">
				<div class="project-wrap">
					<a class="img" style="background-image: url(images/destinasi_5.jpeg);">
					</a>
					<div class="text p-4">
						<h3><a>Tebing Tinggi (Sumatera Utara)</a></h3>
						<p class="location"><span class="fa fa-map-marker"></span> Tebing Tinggi adalah kota yang berada di jalur kereta api Medan – Tebing Tinggi – Siantar. Kota ini merupakan titik transit penting bagi penumpang yang bepergian ke berbagai kota di Sumatera Utara.</p>

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
				<span class="subheading">Testimonial</span>
				<h2 class="mb-4">Tourist Feedback</h2>
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
								<p class="mb-4">Aplikasi bagus. Pesan tiket untuk traveling saya dan keluarga jadi
									gampang. Terima kasih Sonic 🥰
								</p>
								<div class="d-flex align-items-center">
									<div class="user-img" style="background-image: url(images/testimoni_1.jpg)"></div>
									<div class="pl-3">
										<p class="name">KING</p>
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
								<p class="mb-4">Keren nih aplikasinya untuk orang2 yang to the point kayak saya. Gk
									perlu ribet ngeliatin hal2 gk penting.</p>
								<div class="d-flex align-items-center">
									<div class="user-img" style="background-image: url(images/testimoni_2.jpg)"></div>
									<div class="pl-3">
										<p class="name">QUEEN</p>
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
								<p class="mb-4">Aplikasinya cepat dan mudah digunakan. Tidak sulit untuk dimengerti.
									Saya rekomendasikan para pencari tiket Kereta untuk menggunakan aplikasi Sonic
									ini.</p>
								<div class="d-flex align-items-center">
									<div class="user-img" style="background-image: url(images/testimoni_3.jpg)"></div>
									<div class="pl-3">
										<p class="name">SLAVE</p>
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
					<p>Sonic yang berarti kecepatan. Ini menandakan website
						kami memberi respon dengan cepat dan bisa diandalkan. Sesuai dengan kebutuhan pengguna kami.</p>
					<ul class="ftco-footer-social list-unstyled float-md-left float-lft">
						<li class="ftco-animate"><a href="" target="_blank"><span class="fa fa-twitter"></span></a></li>
						<li class="ftco-animate"><a href="" target="_blank"><span class="fa fa-facebook"></span></a></li>
						<li class="ftco-animate"><a href="" target="_blank"><span class="fa fa-instagram"></span></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md pt-5 border-left">
				<div class="ftco-footer-widget pt-md-5 mb-4">
					<h2 class="ftco-heading-2">Have a Questions?</h2>
					<div class="block-23 mb-3">
						<ul>
							<li><span class="icon fa fa-map-marker"></span><span class="text">Gedung Sonic, Jl. Berdikari No.1, Kota Medan, Sumatera Utara</span></li>
							<li><a href=""><span class="icon fa fa-whatsapp"></span><span class="text">081289889888 Admin 1
										</span></a></li>
							<li><a href=""><span class="icon fa fa-whatsapp"></span><span class="text">081365655656 Admin 2
										</span></a></li>
							<li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">Sonic@gmail.com</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">

				<p>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Sonic &copy;
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