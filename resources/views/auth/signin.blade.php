<!DOCTYPE html>
<html lang="en">
<head>
    @include('shared.head-meta')
    <title>MedFinder | Sign In</title>
    @include('shared.head-links')
</head>
<body class="bg-light">
    <div class="container py-4 py-lg-5">
        <div class="row min-vh-100 align-items-center g-4">
            <div class="col-lg-6">
                <div class="pe-lg-5">
                    <span class="badge bg-success-subtle text-success-emphasis mb-3">Welcome back</span>
                    <h1 class="display-5 fw-bold mb-3">Sign in to track medicines, pharmacies, and reservations</h1>
                    <p class="text-secondary fs-5 mb-4">MedFinder helps patients find nearby pharmacies with the medicine they need and lets pharmacies manage visible stock with confidence.</p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="card border-0 shadow-sm h-100"><div class="card-body"><h5>Nearby search</h5><p class="text-secondary mb-0">Let users find available medicine before they travel.</p></div></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card border-0 shadow-sm h-100"><div class="card-body"><h5>Reservation flow</h5><p class="text-secondary mb-0">Track requests from pending to confirmed pickup.</p></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <h2 class="mb-1">Sign in</h2>
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
                            <button type="submit" class="btn btn-dark btn-lg w-100">Sign in</button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-secondary">Need an account?</span>
                            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Create one</a>
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
