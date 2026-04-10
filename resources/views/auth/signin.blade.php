<!DOCTYPE html>
<html lang="en">
<head>
    @include('shared.head-meta')
    <title>MedFinder | Login</title>
    @include('shared.head-links')
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100 align-items-center justify-content-center py-4 py-lg-5" style="background: linear-gradient(180deg, #f8fafc 0%, #f0fdfa 48%, #ffffff 100%);">
        <div class="row w-100 justify-content-center g-4">
            <!-- Left column with info removed to focus on centered login -->
            <div class="col-lg-6 col-xl-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <h2 class="mb-1">Login</h2>
                            <p class="text-secondary mb-0">Access your MedFinder dashboard</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}" class="d-flex flex-column gap-3">
                            @csrf
                            <div>
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required autofocus>
                            </div>
                            <div>
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Keep me signed in</label>
                            </div>
                            <button type="submit" class="btn btn-dark btn-lg w-100">Login</button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-secondary">Need an account?</span>
                            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Signup</a>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('welcome') }}" class="text-secondary text-decoration-none">Back to home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('shared.scripts')
</body>
</html>
