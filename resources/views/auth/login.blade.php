<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login SIPASTI</title>
	<link rel="icon" href="{{ url('/')}}/image/jti-logo.png" type="image/x-icon">
	<!-- Bootstrap CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #ffffff;
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.login-container {
			max-width: 400px;
			width: 90%;
		}

		.card {
			border: none;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
			border-radius: 15px;
			background: white;
			padding: 30px;
		}

		.logo-container {
			text-align: center;
			margin-bottom: 30px;
		}

		.logo-container img {
			width: 120px;
			height: auto;
			margin-bottom: 20px;
		}

		.form-control {
			border-radius: 8px;
			padding: 10px 15px;
			border: 1px solid #ddd;
			margin-bottom: 15px;
		}

		.btn-login {
			background-color: #004AAD;
			border: none;
			border-radius: 8px;
			padding: 12px;
			font-weight: 500;
			width: 100%;
			margin-top: 10px;
		}

		.form-label {
			font-size: 14px;
			color: #666;
			margin-bottom: 8px;
		}

		.password-field {
			position: relative;
		}

		.password-toggle {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: #666;
		}

		/* Dark mode toggle */
		.dark-mode-toggle {
			position: fixed;
			bottom: 20px;
			right: 20px;
			background: transparent;
			border: none;
			color: #666;
			cursor: pointer;
		}
	</style>
</head>

<body>
	<div class="login-container">
		<div class="logo-container">
			<img src="{{ asset('image/jti-logo.png') }}" alt="Logo">
		</div>
		<div class="card">
			<h4 class="text-center mb-4">LOGIN</h4>

			<form action="{{ url('login') }}" method="POST" id="form-login">
				@csrf
				<div class="mb-3">
					<label class="form-label">Username</label>
					<input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username">
					<small id="error-username" class="error-text text-danger"></small>
				</div>

				<div class="mb-3">
					<label class="form-label">Password</label>
					<div class="password-field">
						<input type="password" id="password" name="password" class="form-control"
							placeholder="Masukkan Password">
						<span class="password-toggle" onclick="togglePassword()">
							<i class="far fa-eye" id="toggleIcon"></i>
						</span>
					</div>
					<small id="error-password" class="error-text text-danger"></small>
				</div>

				<button type="submit" class="btn btn-primary btn-login">Masuk</button>
			</form>
		</div>
	</div>

	<!-- Dark mode toggle button -->
	<button class="dark-mode-toggle" onclick="toggleDarkMode()">
		<i class="fas fa-moon"></i>
	</button>

	<!-- Scripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.5/sweetalert2.all.min.js"></script>

	<script>
		// Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Toggle dark mode
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        // Form validation and submission
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
			$("#form-login").validate({
				rules: {
					username: {
						required: true,
						minlength: 4,
						maxlength: 20
					},
					password: {
						required: true,
						minlength: 5,
						maxlength: 20
					}
				},
				messages: {
					username: {
						required: "Username harus diisi",
						minlength: "Username minimal 4 karakter",
						maxlength: "Username maksimal 20 karakter"
					},
					password: {
						required: "Password harus diisi",
						minlength: "Password minimal 5 karakter",
						maxlength: "Password maksimal 20 karakter"
					}
				},
				submitHandler: function (form) {
					$.ajax({
						url: form.action,
						type: form.method,
						data: $(form).serialize(),
						success: function (response) {
							if (response.status) {
								// Langsung redirect ke dashboard
								window.location = response.redirect;
							} else {
								$('.error-text').text('');
								$.each(response.msgField, function (prefix, val) {
									$('#error-' + prefix).text(val[0]);
								});
								// Tampilkan pesan warning
								Swal.fire({
									icon: 'warning',
									title: 'Login Gagal',
									text: response.message,
								});
							}
						},
					});
					return false;
				},
				errorElement: 'span',
				errorPlacement: function (error, element) {
					error.addClass('invalid-feedback');
					element.closest('.mb-3').append(error);
				},
				highlight: function (element, errorClass, validClass) {
					$(element).addClass('is-invalid');
				},
				unhighlight: function (element, errorClass, validClass) {
					$(element).removeClass('is-invalid');
				}
			});
		});

	</script>
</body>

</html>