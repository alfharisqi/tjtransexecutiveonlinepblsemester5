@extends('layouts.main')

@section('front-end')
<link rel="stylesheet" href="{{ asset('plugins/css-components-main/cards/card-8/style.css') }}">

<x-front-navbar></x-front-navbar>

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/train2.jpg'); width: 100%">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
			<div class="col-md-9 ftco-animate pb-5 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="fa fa-chevron-right"></i></a></span> <span>About us <i class="fa fa-chevron-right"></i></span></p>
				<h1 class="mb-0 bread">About Us</h1>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-about ftco-no-pt img">
	<div class="container">
		<div class="row d-flex">
			<div class="col-md-12 about-intro">
				<div class="row">
					<div class="col-md-6 d-flex align-items-stretch">
						<div class="img d-flex w-100 align-items-center justify-content-center" style="background-image:url(images/sonicbiru.jpg);">
						</div>
					</div>
					<div class="col-md-6 pl-md-5 py-5">
						<div class="row justify-content-start pb-3">
							<div class="col-md-12 heading-section ftco-animate">
								<span class="subheading">About Us</span>
								<h2 class="mb-4">SONIC</h2>
								<p>Terinspirasi dari Sonic the Hedgehog. Sonic terkenal karena kecepatannya yang luar biasa, yang mengajarkan nilai-nilai penting seperti ketangkasan, kemampuan untuk merespons dengan cepat terhadap tantangan, dan semangat yang tak kenal lelah. Ketangkasan Sonic menggambarkan pentingnya menjadi lincah dan siap menghadapi perubahan, sementara respons cepatnya menunjukkan bagaimana kesiapan dan kecepatan dalam bertindak dapat membantu mengatasi rintangan dengan efisien. Semangat yang tak kenal lelah yang dimiliki Sonic menginspirasi kita untuk terus maju dan tidak pernah menyerah, meskipun dihadapkan pada kesulitan atau tantangan besar. Sonic adalah simbol dari dedikasi dan kegigihan, mengingatkan kita bahwa dengan tekad dan semangat yang kuat, kita dapat mencapai tujuan kita.

								</p>
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