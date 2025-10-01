<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body text-center">
                <h1 class="h3 mb-4 text-gray-900">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="mb-4">You are now logged in.</p>
                <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit"
                            class="btn btn-primary btn-user btn-sm">                        
                            Logout
                        </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
