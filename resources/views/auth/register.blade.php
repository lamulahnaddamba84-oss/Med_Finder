<!DOCTYPE html>
<html lang="en">
<head>
    @include('shared.head-meta')
    <title>MedFinder | Register</title>
    @include('shared.head-links')
</head>
<body class="bg-light">
    <div class="container py-4 py-lg-5">
        <div class="row min-vh-100 align-items-center g-4">
            <div class="col-lg-5 order-2 order-lg-1">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #083344 0%, #0f766e 60%, #ccfbf1 100%);">
                    <div class="card-body p-4 p-lg-5 text-white">
                        <span class="badge bg-light text-success-emphasis mb-3">Join MedFinder</span>
                        <h1 class="display-6 fw-bold mb-3">Create an account for medicine search or pharmacy onboarding</h1>
                        <p class="mb-0 text-white-50">Users can search for medicine and place reservations. Pharmacies can onboard inventory and grow visibility after subscription.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 order-1 order-lg-2">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="mb-1">Create account</h2>
                        <p class="text-secondary mb-4">Everything is responsive and ready for desktop or mobile use.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('register.store') }}" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-12">
                                <label for="role" class="form-label">Account type</label>
                                <select id="role" name="role" class="form-select form-select-lg" required>
                                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Medicine seeker</option>
                                    <option value="pharmacy" {{ old('role') === 'pharmacy' ? 'selected' : '' }}>Pharmacy account</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-lg w-100">Create account</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-secondary">Already have an account?</span>
                            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Sign in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('shared.scripts')
</body>
</html>
