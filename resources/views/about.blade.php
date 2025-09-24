@extends('layouts.main')

@section('front-end')
<link rel="stylesheet" href="{{ asset('plugins/css-components-main/cards/card-8/style.css') }}">

<x-front-navbar></x-front-navbar>

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/travel2.JPG'); width: 100%">
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
		<div class="row d-flex flex-column flex-md-row">
			<div class="col-md-12 about-intro">
				<div class="row">
					<div class="col-md-6 d-flex align-items-stretch mb-4 mb-md-0">
						<div class="img d-flex w-100 align-items-center justify-content-center" style="background-image:url(images/tjulogo.png); background-size: contain; background-repeat: no-repeat; background-position: center; min-height: 200px;">
						</div>
					</div>
					<div class="col-md-6 pl-md-5 py-5">
						<div class="row justify-content-start pb-3">
							<div class="col-md-12 heading-section ftco-animate">
								<span class="subheading">About Us</span>
								<h2 class="mb-4">TJ TRANS EXECUTIVE</h2>
								<p>TJ Trans Executive adalah perusahaan transportasi yang menyediakan layanan perjalanan berkualitas tinggi dengan fokus pada kenyamanan, keamanan, dan kepuasan pelanggan. Apakah Anda membutuhkan transportasi untuk acara penting, perjalanan bisnis, atau sekadar perjalanan sehari-hari, TJ Trans siap melayani Anda dengan profesionalisme dan dedikasi.</p>
								<p>Dengan armada kendaraan yang terawat dan pengemudi berpengalaman, kami memastikan setiap perjalanan Anda berjalan lancar dan sesuai harapan. Kami berkomitmen untuk terus meningkatkan kualitas layanan kami agar dapat memenuhi kebutuhan dan keinginan pelanggan yang terus berkembang.</p>
								<p><strong>VISI:</strong> Menjadi perusahaan penyedia layanan transportasi darat yang selalu mengutamakan keselamatan, keamanan, dan kenyamanan untuk kepuasan pelanggan.</p>
								<p><strong>MISI:</strong> Memberikan pelayanan dengan kualitas terbaik untuk kepuasan pelanggan pengembangan sistem manajemen yang profesional dan berkelanjutan memberikan kesejahteraan kepada karyawan. </p>
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
						<li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
						<li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
						<li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md pt-5 border-left">
				<div class="ftco-footer-widget pt-md-5 mb-4">
					<h2 class="ftco-heading-2">Have a Questions?</h2>
					<div class="block-23 mb-3">
						<ul>
							<li><span class="icon fa fa-map-marker"></span><span class="text">Alamat</span></li>
							<li><a href="#"><span class="icon fa fa-whatsapp"></span><span class="text">123 Admin 1</span></a></li>
							<li><a href="#"><span class="icon fa fa-whatsapp"></span><span class="text">123 Admin 2</span></a></li>
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
					<script>document.write(new Date().getFullYear());</script>
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
