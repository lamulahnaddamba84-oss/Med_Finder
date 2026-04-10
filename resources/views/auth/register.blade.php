<!DOCTYPE html>
<html lang="en">
<head>
    @include('shared.head-meta')
    <title>MedFinder | Signup</title>
    @include('shared.head-links')
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100 align-items-center justify-content-center py-4 py-lg-5" style="background: linear-gradient(180deg, #f8fafc 0%, #f0fdfa 48%, #ffffff 100%);">
        <div class="row w-100 justify-content-center g-4">
           
          <div class="col-lg-7 mx-auto">
      <div class="card auth-card auth-register-card shadow-lg">
        <div class="card-body p-4 p-lg-5">
          <div class="auth-form-header">
            <div>
              <h2 class="fw-semibold mb-1">Create Account</h2>
              <p class="text-muted mb-0">Fill in your details below to get started.</p>
            </div>
            <div class="small text-muted auth-switch-text">
              Already registered?
              <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
            </div>
          </div>

          <form method="post" action="{{ route('register') }}" class="form-auth">
            @csrf

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="name">Full name</label>
                <input class="form-control" id="name" name="name" required value="{{ old('name') }}" autocomplete="name" placeholder="Enter your full name">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="email">Email address</label>
                <input class="form-control" id="email" type="email" name="email" required value="{{ old('email') }}" autocomplete="email" placeholder="name@example.com">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a secure password">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="roleSelect">Account type</label>
                <select class="form-select" name="role" id="roleSelect" aria-describedby="roleHelp">
                  <option value="patient" {{ old('role', 'patient') === 'patient' ? 'selected' : '' }}>Patient</option>
                  <option value="pharmacist" {{ old('role') === 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                </select>
                <div id="roleHelp" class="form-text">Pharmacist accounts require admin approval before full access.</div>
              </div>
            </div>

            <div id="pharmacyFields" class="pharmacy-fields mt-4 {{ old('role') === 'pharmacist' ? '' : 'd-none' }}">
              <div class="pharmacy-fields-header">
                <h3>Pharmacy details</h3>
                <p>Provide these details if you are registering as a pharmacist.</p>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="pharmacy_name">Pharmacy name</label>
                  <input class="form-control" id="pharmacy_name" name="pharmacy_name" value="{{ old('pharmacy_name') }}" placeholder="Enter pharmacy name">
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="license">License number</label>
                  <input class="form-control" id="license" name="license" value="{{ old('license') }}" placeholder="Enter license number">
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="location">Location</label>
                  <input class="form-control" id="location" name="location" value="{{ old('location') }}" placeholder="City or branch location">
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="phone">Phone number</label>
                  <input class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
                </div>
              </div>
            </div>

            <button class="btn btn-primary w-100 mt-4 auth-submit-btn" type="submit">Create account</button>
          </form>
        </div>
      </div>
    </div>
    @include('shared.scripts')
</body>
</html>
