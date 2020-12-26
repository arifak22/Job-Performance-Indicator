
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Login</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	{{-- <link rel="icon" href="{{url('assets')}}/icon/favicon.png" type="image/x-icon"/> --}}

    <link rel="shortcut icon" href="http://www.ukpbjkarimun.info/assets/_custom/img/favicon.jpg" />
	<!-- Fonts and icons -->
	<script src="{{url('assets')}}/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{url('assets')}}/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{url('assets')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('assets')}}/css/atlantis-pro.css">
    <link rel="stylesheet" href="{{url('assets/_custom')}}/css/style.css">
    
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<h3 class="text-center">Sign In To Admin</h3>
			<form class="login-form">
				<div class="form-group form-floating-label">
					<input id="username" name="username" type="text" class="form-control input-border-bottom" required>
					<label for="username" class="placeholder">Username</label>
				</div>
				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
					<label for="password" class="placeholder">Password</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
				</div>
				<div class="row form-sub m-0">
					{{-- <div class="custom-control custom-checkbox">
						<input type="checkbox" name="remember" class="custom-control-input" id="rememberme">
						<label class="custom-control-label" for="rememberme">Remember Me</label>
					</div>
					 --}}
					{{-- <a href="#" class="link float-right">Forget Password ?</a> --}}
				</div>
				<div class="form-action mb-3">
					<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
				</div>
				{{-- <div class="login-account">
					<span class="msg">Don't have an account yet ?</span>
					<a href="#" id="show-signup" class="link">Sign Up</a>
				</div> --}}
			</form>
		</div>

		<div class="container container-signup animated fadeIn">
			<h3 class="text-center">Sign Up</h3>
			<div class="login-form">
				<div class="form-group form-floating-label">
					<input  id="fullname" name="fullname" type="text" class="form-control input-border-bottom" required>
					<label for="fullname" class="placeholder">Fullname</label>
				</div>
				<div class="form-group form-floating-label">
					<input  id="email" name="email" type="email" class="form-control input-border-bottom" required>
					<label for="email" class="placeholder">Email</label>
				</div>
				<div class="form-group form-floating-label">
					<input  id="passwordsignin" name="passwordsignin" type="password" class="form-control input-border-bottom" required>
					<label for="passwordsignin" class="placeholder">Password</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
				</div>
				<div class="form-group form-floating-label">
					<input  id="confirmpassword" name="confirmpassword" type="password" class="form-control input-border-bottom" required>
					<label for="confirmpassword" class="placeholder">Confirm Password</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
				</div>
				<div class="row form-sub m-0">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="agree" id="agree">
						<label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
					</div>
				</div>
				<div class="form-action">
					<a href="#" id="show-signin" class="btn btn-danger btn-link btn-login mr-3">Cancel</a>
					<a href="#" class="btn btn-primary btn-rounded btn-login">Sign Up</a>
				</div>
			</div>
		</div>
    </div>
    
	<script src="{{url('assets')}}/js/core/jquery.3.2.1.min.js"></script>
	<script src="{{url('assets')}}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="{{url('assets')}}/js/core/popper.min.js"></script>
	<script src="{{url('assets')}}/js/core/bootstrap.min.js"></script>
    <script src="{{url('assets')}}/js/atlantis-pro.min.js"></script>
	<script src="{{url('assets')}}/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="{{url('assets')}}/js/plugin/jquery.validate.min.js"></script> 
	<script src="{{url('assets')}}/js/plugin/jquery.form.min.js"></script> 
	<script src="{{url('assets')}}/_custom/js/script.js"></script> 
    <script>
        $('.btn-login').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                }
            });
            if (!form.valid()) {
                return;
            }
			apiLoading(true, btn);            
			form.ajaxSubmit({
				url : "{{url('login/auth')}}",
				data: { _token: "{{ csrf_token() }}" },
				type: 'POST',
				success: function(response) {
					apiLoading(false, btn);
					apiRespone(response,
						function(res){
							if(res.api_status == 1){
								localStorage.setItem("pelops_token", response.jwt_token);
							}
						},
						() => {
							window.location = "{{Request::session()->get('last_url')}}";
						}
					);
				},
				error: function(error){
					apiLoading(false, btn);
					swal(error.statusText);
				}
			});
        });
    </script>
</body>
</html>