<!DOCTYPE html>
<html lang="en">
<head>
	<title>home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/udc.png" alt="IMG">
				</div>

				<form class="login100-form validate-form"  method="POST" action="{{ route('accueil') }}">
          @csrf
					<span class="login100-form-title">
						Se connecter
					</span>
          <div class="card-body">
            @error('matricule')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
					<div class="wrap-input100 validate-input" data-validate = "Validation matricule est requis: ex@abc.xyz" :value="__('Matricule')">
						<input class="input100" type="text" placeholder="Matricule" name="matricule" :value="old('matricule')" required autofocus>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
          @error('password')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror
					<div class="wrap-input100 validate-input" data-validate = "Le Mot de passe est requis" :value="__('Password')">
						<input class="input100" type="password" placeholder="Mot de passe"  name="password"
            required autocomplete="current-password" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
              {{ __('Se connecter') }}
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
              @if (Route::has('password.request'))
              {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                  {{ __('Forgot your password?') }}
              </a> --}}
          @endif
						</span>
						<a class="txt2" href="#">
							{{-- Username / Password? --}}
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
						  @if (Route::has('register'))
                            {{-- <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Mot de passe</a> --}}
                        @endif
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="login/js/main.js"></script>

</body>
</html>
