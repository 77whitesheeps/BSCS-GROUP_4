<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body style="background-color: #f3f9f4;"> <!-- light greenish background -->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-5">
                    
                    <!-- Branding -->
                    <div class="text-center mb-4">
                        <h1 class="h3 font-weight-bold" style="color:#68af2C;"> Plant-O-Matic</h1>
                        <h2 class="h5 text-gray-900">Login</h2>
                    </div>

                    <!-- Success message -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Error message -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form class="user" action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="form-control form-control-user" 
                                   placeholder="Email Address">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" 
                                   class="form-control form-control-user" 
                                   placeholder="Password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Green Login Button -->
                        <button type="submit" class="btn btn-user btn-block" 
                                style="background-color:#68af2C; border-color:#68af2C; color:white;">
                            Login
                        </button>

                        <hr>

                        <!-- Social Logins -->
                        <a href="{{ url('auth/google') }}" class="btn btn-google btn-user btn-block">
                            <i class="fab fa-google fa-fw"></i> Login with Google
                        </a>
                    </form>

                    <hr>

                    <!-- Links -->
                    <div class="text-center">
                        <a class="small" href="{{ url('/forgot-password') }}">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="{{ url('/register') }}">Don't have an account? Register!</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
