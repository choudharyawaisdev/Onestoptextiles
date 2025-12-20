<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LUXE THREAD | Premium Clothing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title')</title>
    @include('includes.style')

</head>

<body>
	<div class="page">
		@include('includes.header')
		<main class="content">
			@yield('body')
		</main>
	</div>
	@include('includes.script')
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-4 mb-4">
					<h4 class="footer-title">LUXE<span>THREAD</span></h4>
					<p class="text-muted small">Elevate your everyday wardrobe with our curated collection of premium
						essentials. Quality you can feel.</p>
					<div class="mt-3">
						<a href="#" class="mr-3 text-dark"><i class="fab fa-instagram"></i></a>
						<a href="#" class="mr-3 text-dark"><i class="fab fa-facebook-f"></i></a>
						<a href="#" class="text-dark"><i class="fab fa-pinterest"></i></a>
					</div>
				</div>
				<div class="col-6 col-md-2 mb-4">
					<h6 class="font-weight-bold">Shop</h6>
					<a href="#" class="footer-link">Women</a>
					<a href="#" class="footer-link">Men</a>
					<a href="#" class="footer-link">Shoes</a>
					<a href="#" class="footer-link">Accessories</a>
				</div>
				<div class="col-6 col-md-2 mb-4">
					<h6 class="font-weight-bold">Help</h6>
					<a href="#" class="footer-link">Shipping</a>
					<a href="#" class="footer-link">Return Policy</a>
					<a href="#" class="footer-link">Size Guide</a>
					<a href="#" class="footer-link">Contact</a>
				</div>
				<div class="col-md-4 mb-4">
					<h6 class="font-weight-bold">Newsletter</h6>
					<p class="text-muted small">Sign up for exclusive offers and news.</p>
					<div class="input-group">
						<input type="email" class="form-control rounded-0" placeholder="Email address">
						<div class="input-group-append">
							<button class="btn btn-dark rounded-0 px-4">JOIN</button>
						</div>
					</div>
				</div>
			</div>
			<div class="text-center pt-4 border-top">
				<p class="text-muted xsmall">&copy; 2024 LuxeThread. Designed for Style.</p>
			</div>
		</div>
	</footer>
</body>

</html>