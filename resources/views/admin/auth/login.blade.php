<!DOCTYPE html>
<!-- 
Jampack
Author: Hencework
Contact: contact@hencework.com
-->
<html lang="en">
<head>
    <!-- Meta Tags -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-commerce Dashboard</title>
    <meta name="description" content="E-commerce Admin Dashboard Login"/>
    
	<!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
	
	<!-- CSS -->
    <link href="{{ asset('admin/dist/css/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
   	<!-- Wrapper -->
	<div class="hk-wrapper hk-pg-auth" data-footer="simple">
		<!-- Main Content -->
		<div class="hk-pg-wrapper pt-0 pb-xl-0 pb-5">
			<div class="hk-pg-body pt-0 pb-xl-0">
				<!-- Container -->
				<div class="container-xxl">
					<!-- Row -->
					<div class="row">
						<div class="col-sm-10 position-relative mx-auto">
							<div class="auth-content py-8">
								<form class="w-100" method="POST" action="{{ route('admin.login') }}">
									@csrf
									<div class="row">
										<div class="col-lg-5 col-md-7 col-sm-10 mx-auto">
											<div class="text-center mb-7">
												<a class="navbar-brand me-0" href="{{ route('admin.home') }}">
													<img class="brand-img d-inline-block" src="{{ asset('admin/dist/img/logo-light.png') }}" alt="Brand Logo">
												</a>
											</div>
											<div class="card card-lg card-border">
												<div class="card-body">
													<h4 class="mb-4 text-center">Sign in to your account</h4>
													
													@if ($errors->any())
														<div class="alert alert-danger mb-4">
															<ul class="mb-0">
																@foreach ($errors->all() as $error)
																	<li>{{ $error }}</li>
																@endforeach
															</ul>
														</div>
													@endif

													<div class="row gx-3">
														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label>Email Address</label>
															</div>
															<input class="form-control @error('email') is-invalid @enderror" 
																   placeholder="Enter your email address" 
																   value="{{ old('email') }}" 
																   type="email" 
																   name="email" 
																   required 
																   autofocus>
															@error('email')
																<div class="invalid-feedback">{{ $message }}</div>
															@enderror
														</div>
														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label>Password</label>
																<a href="#" class="fs-7 fw-medium">Forgot Password?</a>
															</div>
															<div class="input-group password-check">
																<span class="input-affix-wrapper">
																	<input class="form-control @error('password') is-invalid @enderror" 
																		   placeholder="Enter your password" 
																		   type="password" 
																		   name="password" 
																		   required>
																	<a href="#" class="input-suffix text-muted" onclick="togglePassword()">
																		<span class="feather-icon"><i class="form-icon" data-feather="eye"></i></span>
																		<span class="feather-icon d-none"><i class="form-icon" data-feather="eye-off"></i></span>
																	</a>
																</span>
															</div>
															@error('password')
																<div class="invalid-feedback d-block">{{ $message }}</div>
															@enderror
														</div>
													</div>
													<div class="d-flex justify-content-center">
														<div class="form-check form-check-sm mb-3">
															<input type="checkbox" class="form-check-input" id="remember_token" name="remember_token" {{ old('remember_token') ? 'checked' : '' }}>
															<label class="form-check-label text-muted fs-7" for="remember_token">Remember me</label>
														</div>
													</div>
													<button type="submit" class="btn btn-primary btn-uppercase btn-block">Login</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /Row -->
				</div>
				<!-- /Container -->
			</div>
			<!-- /Page Body -->

			<!-- Page Footer -->
			<div class="hk-footer border-0">
				<footer class="container-xxl footer">
					<div class="row">
						<div class="col-xl-8 text-center">
							<p class="footer-text pb-0"><span class="copy-text">E-commerce Store © {{ date('Y') }} All rights reserved.</span></p>
						</div>
					</div>
				</footer>
			</div>
			<!-- / Page Footer -->
		
		</div>
		<!-- /Main Content -->
	</div>
    <!-- /Wrapper -->

	<!-- jQuery -->
    <script src="{{ asset('admin/vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
   	<script src="{{ asset('admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- FeatherIcons JS -->
    <script src="{{ asset('admin/dist/js/feather.min.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('admin/dist/js/dropdown-bootstrap-extended.js') }}"></script>

	<!-- Simplebar JS -->
	<script src="{{ asset('admin/vendors/simplebar/dist/simplebar.min.js') }}"></script>
	
	<!-- Init JS -->
	<script src="{{ asset('admin/dist/js/init.js') }}"></script>

	<script>
		function togglePassword() {
			const passwordInput = document.querySelector('input[name="password"]');
			const eyeIcons = document.querySelectorAll('.feather-icon');
			
			if (passwordInput.type === 'password') {
				passwordInput.type = 'text';
				eyeIcons[0].classList.add('d-none');
				eyeIcons[1].classList.remove('d-none');
			} else {
				passwordInput.type = 'password';
				eyeIcons[0].classList.remove('d-none');
				eyeIcons[1].classList.add('d-none');
			}
		}
	</script>
</body>
</html>