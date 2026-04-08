@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
  <div class="d-flex flex-column gap-4">
    <section class="card border-0 shadow-sm overflow-hidden">
      <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #083344 0%, #0f766e 45%, #34d399 100%); color: #f8fffe;">
        <div class="row align-items-center g-4">
          <div class="col-lg-8">
            <span class="badge bg-light text-success-emphasis mb-3">Admin Dashboard</span>
            <h2 class="display-6 mb-3">MedFinder overview for medicine discovery, pharmacy subscriptions, and reservations</h2>
            <p class="mb-0 text-white-50">Track how many users are searching for medicine, how many pharmacies have joined, which pharmacies are still pending review, and how reservations are moving through the platform.</p>
          </div>
          <div class="col-lg-4">
            <div class="bg-white bg-opacity-10 rounded-4 p-4">
              <div class="small text-uppercase text-white-50 mb-2">Operations snapshot</div>
              <div class="fs-2 fw-bold">{{ number_format($stats['reservations']) }}</div>
              <div class="text-white-50">total medicine reservations logged across MedFinder</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="row g-4">
      <div class="col-md-6 col-xl-3">
        <div class="card card-lg border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Registered users</p><h3 class="mb-1">{{ number_format($stats['users']) }}</h3><small class="text-secondary">People searching for nearby medicine availability</small></div></div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card card-lg border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Pharmacies on MedFinder</p><h3 class="mb-1">{{ number_format($stats['pharmacies']) }}</h3><small class="text-secondary">Approved and pending pharmacies in the network</small></div></div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card card-lg border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Medicine listings</p><h3 class="mb-1">{{ number_format($stats['medicines']) }}</h3><small class="text-secondary">Types of medicines entered by pharmacies</small></div></div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card card-lg border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Reservations made</p><h3 class="mb-1">{{ number_format($stats['reservations']) }}</h3><small class="text-secondary">All medicine reservations created by users</small></div></div>
      </div>
    </section>

    <section class="row g-4">
      <div class="col-xl-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h4 class="mb-4">Pharmacy subscription health</h4>
            <div class="d-flex flex-column gap-3">
              <div class="p-3 rounded-3 bg-success-subtle">
                <div class="small text-success-emphasis">Subscribed pharmacies</div>
                <div class="fs-3 fw-bold text-success-emphasis">{{ number_format($stats['subscribedPharmacies']) }}</div>
              </div>
              <div class="p-3 rounded-3 bg-warning-subtle">
                <div class="small text-warning-emphasis">Pending pharmacies</div>
                <div class="fs-3 fw-bold text-warning-emphasis">{{ number_format($stats['pendingPharmacies']) }}</div>
              </div>
              <div class="p-3 rounded-3 bg-info-subtle">
                <div class="small text-info-emphasis">Active reservations</div>
                <div class="fs-3 fw-bold text-info-emphasis">{{ number_format($stats['activeReservations']) }}</div>
              </div>
              <div class="p-3 rounded-3 bg-primary-subtle">
                <div class="small text-primary-emphasis">Fulfilled reservations</div>
                <div class="fs-3 fw-bold text-primary-emphasis">{{ number_format($stats['fulfilledReservations']) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div>
                <h4 class="mb-1">Medicine categories entered by pharmacies</h4>
                <p class="text-secondary mb-0">A quick view of what patients can currently search for.</p>
              </div>
            </div>

            @if ($medicineCategories->isEmpty())
              <div class="alert alert-light border">No medicine categories yet. Run the MedFinder migrations and seeders to populate this area.</div>
            @else
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>Total medicines</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($medicineCategories as $category)
                      <tr>
                        <td>{{ $category->category }}</td>
                        <td>{{ number_format($category->total) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <section class="row g-4">
      <div class="col-xl-7">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h4 class="mb-4">Recent reservations</h4>
            @if ($recentReservations->isEmpty())
              <div class="alert alert-light border mb-0">No reservations yet. Once users start reserving medicine, their requests will appear here.</div>
            @else
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Medicine</th>
                      <th>Pharmacy</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($recentReservations as $reservation)
                      <tr>
                        <td>{{ $reservation->user?->name ?? 'Unknown user' }}</td>
                        <td>{{ $reservation->medicine?->name ?? 'Unknown medicine' }}</td>
                        <td>{{ $reservation->pharmacy?->name ?? 'Unknown pharmacy' }}</td>
                        <td><span class="badge bg-light text-dark text-capitalize">{{ str_replace('_', ' ', $reservation->status) }}</span></td>
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
            <h4 class="mb-4">Latest pharmacies</h4>
            @if ($pharmacySnapshot->isEmpty())
              <div class="alert alert-light border mb-0">No pharmacy records yet. Pending and subscribed pharmacies will show here after migration.</div>
            @else
              <div class="d-flex flex-column gap-3">
                @foreach ($pharmacySnapshot as $pharmacy)
                  <div class="border rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                      <div>
                        <h5 class="mb-1">{{ $pharmacy->name }}</h5>
                        <p class="text-secondary mb-1">{{ $pharmacy->city }}</p>
                        <small class="text-secondary">{{ $pharmacy->subscription_plan ?: 'No subscription yet' }}</small>
                      </div>
                      <div class="text-end">
                        <span class="badge {{ $pharmacy->status === 'approved' ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }} text-capitalize">{{ $pharmacy->status }}</span>
                        <div class="small text-secondary mt-2">{{ $pharmacy->is_subscribed ? 'Subscribed' : 'Awaiting activation' }}</div>
                      </div>
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
