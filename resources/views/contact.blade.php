@extends('layouts.main')

@section('front-end')
<x-front-navbar></x-front-navbar>

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/travel4.JPG'); background-size: cover; background-position: center center;">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
			<div class="col-md-9 ftco-animate pb-5 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="fa fa-chevron-right"></i></a></span> <span>Contact us <i class="fa fa-chevron-right"></i></span></p>
				<h1 class="mb-0 bread">Contact us</h1>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-no-pb contact-section mb-4">
	<div class="container">
		<div class="row d-flex contact-info">
			<div class="col-md-4 col-sm-12 d-flex mb-3">
				<div class="align-self-stretch box p-4 text-center w-100">
					<div class="icon d-flex align-items-center justify-content-center mb-2">
						<span class="fa fa-map-marker"></span>
					</div>
					<h3 class="mb-2">Address</h3>
					<p>Alamat</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 d-flex mb-3">
				<div class="align-self-stretch box p-4 text-center w-100">
					<div class="icon d-flex align-items-center justify-content-center mb-2">
						<span class="fa fa-phone"></span>
					</div>
					<h3 class="mb-2">Contact Number</h3>
					<p><a href="">081289889888 Admin 1</a></p>
					<p><a href="">081365655656 Admin 2</a></p>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 d-flex mb-3">
				<div class="align-self-stretch box p-4 text-center w-100">
					<div class="icon d-flex align-items-center justify-content-center mb-2">
						<span class="fa fa-paper-plane"></span>
					</div>
					<h3 class="mb-2">Email Address</h3>
					<p><a href="">tjtrans@gmail.com</a></p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section contact-section ftco-no-pt mt-2">
	<div class="container">
		<div class="row block-9">
			<div class="col-md-12 d-flex justify-content-center">
				<div style="width: 100%; max-width: 100%; overflow: hidden;">
					<iframe src="https://maps.app.goo.gl/Sub9VrnGNWp5hNGt9" style="border:0; width: 100%; height: 300px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
		</div>
	</div>
</section>

<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url(images/bg_3.jpg); background-size: cover;">
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
							<li><a href=""><span class="icon fa fa-whatsapp"></span><span class="text">123 Admin 1</span></a></li>
							<li><a href=""><span class="icon fa fa-whatsapp"></span><span class="text">123 Admin 2</span></a></li>
							<li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">tjtransexecutive@gmail.com</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<p>
					TJ Trans Executive &copy;
					<script>
						document.write(new Date().getFullYear());
					</script>
				</p>
			</div>
		</div>
	</div>
</footer>

<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
	<svg class="circular" width="48px" height="48px">
		<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
		<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
	</svg>
</div>
@endsection
