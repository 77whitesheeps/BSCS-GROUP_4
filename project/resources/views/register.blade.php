<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Plant-O-Matic</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Make background soft green */
        body {
            background: #eaf5e1;
        }
        .btn-plant {
            background-color: #68af2C;
            border-color: #68af2C;
            color: white;
        }
        .btn-plant:hover {
            background-color: #5a9625;
            border-color: #5a9625;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Center Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">

                        <!-- App Title -->
                        <div class="text-center mb-4">
                            <h1 class="h3 font-weight-bold" style="color:#68af2C;">Plant-O-Matic</h1>
                            <h2 class="h5 text-gray-900">Create an Account!</h2>
                        </div>

                        {{-- Success message --}}
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        {{-- Error messages --}}
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Registration Form --}}
                        <form class="user" action="{{ route('register') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control form-control-user @error('name') is-invalid @enderror" 
                                    placeholder="Full Name" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control form-control-user @error('email') is-invalid @enderror" 
                                    placeholder="Email Address" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" 
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        placeholder="Password" required>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-user" 
                                        placeholder="Repeat Password" required>
                                </div>
                            </div>

                            <!-- Main Register Button -->
                            <button type="submit" class="btn btn-plant btn-user btn-block">
                                Register Account
                            </button>

                            <hr>
                            
                            <!-- Google Registration Button -->
                            <a href="{{ route('google.redirect') }}" class="btn btn-danger btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> Register with Google
                            </a>
                        </form>

                        <hr>
                        
                        <!-- Links -->
                        <div class="text-center">
                            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
