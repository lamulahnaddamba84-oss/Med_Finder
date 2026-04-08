@extends('layouts.app')

@section('title', 'Pharmacy Dashboard')

@section('content')
  <div class="d-flex flex-column gap-4">
    <section class="card border-0 shadow-sm overflow-hidden">
      <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #1f2937 0%, #0f766e 55%, #99f6e4 100%); color: #f8fffe;">
        <div class="row g-4 align-items-center">
          <div class="col-lg-8">
            <span class="badge bg-light text-success-emphasis mb-3">Pharmacy Hub</span>
            <h2 class="display-6 mb-3">Manage inventory visibility and reservation readiness</h2>
            <p class="mb-0 text-white-50">This dashboard helps pharmacies understand how many medicine listings are visible, how many locations are subscribed, and how reservation demand is distributed across the network.</p>
          </div>
          <div class="col-lg-4">
            <div class="bg-white bg-opacity-10 rounded-4 p-4">
              <div class="small text-uppercase text-white-50 mb-2">In-stock medicines</div>
              <div class="fs-2 fw-bold">{{ number_format($stats['inStockMedicines']) }}</div>
              <div class="text-white-50">listings currently available for reservation</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="row g-4">
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Registered pharmacies</p><h3 class="mb-1">{{ number_format($stats['pharmacies']) }}</h3><small class="text-secondary">Total locations onboarded to MedFinder</small></div></div></div>
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Subscribed pharmacies</p><h3 class="mb-1">{{ number_format($stats['subscribedPharmacies']) }}</h3><small class="text-secondary">Locations with active subscription plans</small></div></div></div>
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Pending pharmacies</p><h3 class="mb-1">{{ number_format($stats['pendingPharmacies']) }}</h3><small class="text-secondary">Locations awaiting approval or subscription</small></div></div></div>
      <div class="col-md-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary mb-2">Medicine entries</p><h3 class="mb-1">{{ number_format($stats['medicines']) }}</h3><small class="text-secondary">All medicines uploaded by partner pharmacies</small></div></div></div>
    </section>

    <section class="row g-4">
      <div class="col-xl-7">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h4 class="mb-4">Recently added medicines</h4>
            @if ($recentMedicines->isEmpty())
              <div class="alert alert-light border mb-0">No medicines have been added yet.</div>
            @else
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Medicine</th>
                      <th>Category</th>
                      <th>Pharmacy</th>
                      <th>Stock</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($recentMedicines as $medicine)
                      <tr>
                        <td>
                          <div class="fw-semibold">{{ $medicine->name }}</div>
                          <small class="text-secondary">{{ $medicine->form ?: 'Standard form' }} {{ $medicine->strength }}</small>
                        </td>
                        <td>{{ $medicine->category }}</td>
                        <td>{{ $medicine->pharmacy?->name ?? 'Unknown pharmacy' }}</td>
                        <td>{{ number_format($medicine->stock) }}</td>
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
            <h4 class="mb-4">Reservation status mix</h4>
            @if ($reservationStatuses->isEmpty())
              <div class="alert alert-light border mb-0">Reservation activity will appear here once users begin reserving medicine.</div>
            @else
              <div class="d-flex flex-column gap-3">
                @foreach ($reservationStatuses as $status)
                  <div class="p-3 rounded-4 border d-flex justify-content-between align-items-center">
                    <div>
                      <div class="fw-semibold text-capitalize">{{ str_replace('_', ' ', $status->status) }}</div>
                      <small class="text-secondary">Current reservation pipeline</small>
                    </div>
                    <span class="fs-4 fw-bold">{{ number_format($status->total) }}</span>
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
