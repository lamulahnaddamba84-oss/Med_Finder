@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
  <div class="d-flex flex-column gap-4">
    <section class="card border-0 shadow-sm overflow-hidden">
      <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #164e63 0%, #2563eb 55%, #bfdbfe 100%); color: #f8fffe;">
        <div class="row g-4 align-items-center">
          <div class="col-lg-8">
            <span class="badge bg-light text-primary-emphasis mb-3">User Search</span>
            <h2 class="display-6 mb-3">Help patients find medicine in nearby pharmacies before leaving home</h2>
            <p class="mb-0 text-white-50">This view focuses on search-ready medicine listings, pharmacy coverage, and the current reservation volume across the MedFinder network.</p>
          </div>
          <div class="col-lg-4">
            <div class="bg-white bg-opacity-10 rounded-4 p-4">
              <div class="small text-uppercase text-white-50 mb-2">Nearby pharmacies</div>
              <div class="fs-2 fw-bold">{{ number_format($stats['nearbyPharmacies']) }}</div>
              <div class="text-white-50">approved pharmacies a user can search across</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="row g-4">
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Users on platform</p><h3 class="mb-1">{{ number_format($stats['users']) }}</h3><small class="text-secondary">People actively using MedFinder</small></div></div></div>
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Available medicines</p><h3 class="mb-1">{{ number_format($stats['availableMedicines']) }}</h3><small class="text-secondary">Listings currently in stock</small></div></div></div>
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Nearby pharmacies</p><h3 class="mb-1">{{ number_format($stats['nearbyPharmacies']) }}</h3><small class="text-secondary">Approved pharmacies available for search</small></div></div></div>
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Reservations made</p><h3 class="mb-1">{{ number_format($stats['reservations']) }}</h3><small class="text-secondary">Total requests to reserve medicine</small></div></div></div>
    </section>

    <section class="row g-4">
      <div class="col-xl-7">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h4 class="mb-4">Featured medicines available now</h4>
            @if ($featuredMedicines->isEmpty())
              <div class="alert alert-light border mb-0">No in-stock medicines yet. Once pharmacies add medicine inventory, users will see it here.</div>
            @else
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Medicine</th>
                      <th>Category</th>
                      <th>Pharmacy</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($featuredMedicines as $medicine)
                      <tr>
                        <td>
                          <div class="fw-semibold">{{ $medicine->name }}</div>
                          <small class="text-secondary">{{ $medicine->strength ?: 'Standard dose' }}</small>
                        </td>
                        <td>{{ $medicine->category }}</td>
                        <td>{{ $medicine->pharmacy?->name ?? 'Unknown pharmacy' }}<br><small class="text-secondary">{{ $medicine->pharmacy?->city }}</small></td>
                        <td>KES {{ number_format($medicine->price, 2) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>

      <div class="col-xl-5">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h4 class="mb-4">Pharmacies users can rely on</h4>
            @if ($featuredPharmacies->isEmpty())
              <div class="alert alert-light border mb-0">Approved pharmacies will appear here after MedFinder onboarding begins.</div>
            @else
              <div class="d-flex flex-column gap-3">
                @foreach ($featuredPharmacies as $pharmacy)
                  <div class="border rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                      <div>
                        <h5 class="mb-1">{{ $pharmacy->name }}</h5>
                        <p class="text-secondary mb-1">{{ $pharmacy->city }}</p>
                        <small class="text-secondary">{{ $pharmacy->address }}</small>
                      </div>
                      <span class="badge {{ $pharmacy->is_subscribed ? 'bg-success-subtle text-success-emphasis' : 'bg-light text-dark' }}">{{ $pharmacy->is_subscribed ? 'Subscribed' : 'Standard' }}</span>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
