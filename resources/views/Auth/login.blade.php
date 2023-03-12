<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | LIDITUNE</title>
    <link rel="stylesheet" href="assets/css/main/custom.css">
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="icon" href="{{ asset('assets/logo1.png') }}" type="image/x-icon">

    <style>
        .toast-success {
            background-color: #2192FF !important;
        }

        .toast-error {
            background-color: #bd362f !important;
        }
    </style>
</head>

<body>
    <script src="assets/js/initTheme.js"></script>
    <div id="auth" style="overflow: hidden">
        <div class="row">
            <div class="col-lg-5 col-12">
                <div>
                    @if (session()->has('error'))
                        <div class="alert alert-danger">{!! session('error') !!}
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success">{!! session('success') !!}
                        </div>
                    @endif
                </div>
                <div id="auth-left">
                    <div class="auth-logo">
                        <img src="{{ asset('assets/logo1.png') }}" id="logo_login" alt="Logo"style="height: 170px;">
                    </div>
                    {{-- <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">
                        Log in with your data that you entered during registration.
                    </p> --}}

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl btn-user"
                                id="email" placeholder="Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl"
                                placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="float-end">
                            <label for=""> <a href="#">Lupa password ?</a> </label>
                        </div>
                        {{-- <button type="login" class="btn btn-login">Login</button> --}}
                        <button class="btn-login btn-lg shadow-lg mt-5">
                            LOGIN
                        </button>
                    </form>
                    {{-- <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="auth-register.html" class="font-bold">Sign up</a>.
                        </p>
                        <p>
                            <a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.
                        </p>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"><img src="assets/18.png"
                        alt="Logo"style="height: 600px; padding: 0% 0% 0% 0%;"></div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // show the alert
            setTimeout(function() {
                $(".alert").alert('close');
            }, 2000);
        });
    </script>
</body>

</html>
