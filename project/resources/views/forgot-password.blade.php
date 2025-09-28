<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - Plant-O-Matic</title>
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body style="background-color: #eaf5e1;">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 font-weight-bold" style="color:#68af2C;">Plant-O-Matic</h1>
                        <h2 class="h5 text-gray-900">Forgot Password</h2>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('/forgot-password') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user" placeholder="Enter your email address" required>
                        </div>
                        <button type="submit" class="btn btn-user btn-block" style="background-color:#68af2C; border-color:#68af2C; color:white;">Send Reset Link</button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ url('/login') }}">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
