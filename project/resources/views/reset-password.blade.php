<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Plant-O-Matic</title>
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body style="background-color: #eaf5e1;">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 font-weight-bold" style="color:#68af2C;">Plant-O-Matic</h1>
                        <h2 class="h5 text-gray-900">Reset Password</h2>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('/reset-password') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-user" placeholder="New Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" class="form-control form-control-user" placeholder="Confirm New Password" required>
                        </div>
                        <button type="submit" class="btn btn-user btn-block" style="background-color:#68af2C; border-color:#68af2C; color:white;">Reset Password</button>
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
