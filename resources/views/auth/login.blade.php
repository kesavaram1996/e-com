<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>ADESHA</title>
		<meta name="description" content="Elmer is a Dashboard & Admin Site Responsive Template by hencework." />
		<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Elmer Admin, Elmeradmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
		<meta name="author" content="hencework"/>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<!-- vector map CSS -->
		<link href="vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
		
		
		
		<!-- Custom CSS -->
		<link href="dist/css/style.css" rel="stylesheet" type="text/css">
		<style>
			.invalid-feedback{
				color: red;
			}
			.capcha{
				margin-left: 10%;
			}
		</style>
	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper  pa-0">
			<header class="sp-header">
				<div class="sp-logo-wrap pull-left">
					<a href="index.html">
						<img class="brand-img mr-10" src="dist/img/logo.png" alt="brand"/>
						<span class="brand-text">Adesha</span>
					</a>
				</div>
				<div class="form-group mb-0 pull-right">
					<!-- <span class="inline-block pr-10">Don't have an account?</span> -->
					<!-- <a class="inline-block btn btn-primary  btn-rounded btn-outline" href="signup.html">Sign Up</a> -->
				</div>
				<div class="clearfix"></div>
			</header>
			
			<!-- Main Content -->
			<div class="page-wrapper pa-0 ma-0 auth-page">
				<div class="container-fluid">
					<!-- Row -->
					<div class="table-struct full-width full-height">
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="mb-30">
                                            <div class="text-center mb-10">
                                                <img width="300px" src="{{ asset('images/adesha_logo.jpg') }}" alt="logo">
                                            </div>
											<h3 class="text-center txt-dark mb-10">Sign in to Dashboard</h3>
											<!-- <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6> -->
										</div>	
										<div class="form-wrap">
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
												<div class="form-group">
													<label class="control-label mb-10" for="email">{{ __('Email Address') }}</label>
													<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required="" id="exampleInputEmail_2" placeholder="Enter email" autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
												</div>
												<div class="form-group">
													<label class="pull-left control-label mb-10" for="password">{{ __('Password') }}</label>
                                                    @if (Route::has('password.request'))
													<a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                                    @endif
													<div class="clearfix"></div>
													<input type="password" class="form-control" required="" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
												</div>
												
												<div class="form-group">
													<div class="checkbox checkbox-primary pr-10 pull-left">
														<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
														<label for="checkbox_2"> {{ __('Remember Me') }}</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="form-group capcha">
													{!! NoCaptcha::renderJs() !!}
													{!! NoCaptcha::display() !!}
													@if ($errors->has('g-recaptcha-response'))
														<span class="help-block">
															<strong style="color:red;">{{ $errors->first('g-recaptcha-response') }}</strong>
														</span>
													@endif
												</div>
												<div class="form-group text-center">
													<button type="submit" class="btn btn-primary  btn-rounded">{{ __('Login') }}</button>
												</div>
											</form>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->	
				</div>
				
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
		
		<!-- Slimscroll JavaScript -->
		<script src="dist/js/jquery.slimscroll.js"></script>
		
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
	</body>
</html>
