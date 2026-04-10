@extends('layouts.public')

@section('title', 'MedFinder | How It Works')

@section('content')
    <section class="mb-5">
        <div class="public-card rounded-5 p-4 p-lg-5">
            <div class="section-kicker mb-2">How It Works</div>
            <h1 class="display-5 fw-bold mb-3">A clear process for finding and reserving medicine</h1>
            <p class="fs-5 text-secondary mb-0">MedFinder brings patients and pharmacies into one connected workflow so medicine access feels simple and predictable.</p>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-md-6 col-xl-3"><div class="public-card rounded-4 p-4 h-100"><h4>1. Search medicine</h4><p class="text-secondary mb-0">Users search by medicine name, category, dosage, form, or strength.</p></div></div>
        <div class="col-md-6 col-xl-3"><div class="public-card rounded-4 p-4 h-100"><h4>2. Compare results</h4><p class="text-secondary mb-0">The platform shows matching medicines, pharmacy location, stock, and pricing information.</p></div></div>
        <div class="col-md-6 col-xl-3"><div class="public-card rounded-4 p-4 h-100"><h4>3. Login or signup</h4><p class="text-secondary mb-0">Patients and pharmacy teams can create an account and continue into their role-specific dashboard.</p></div></div>
        <div class="col-md-6 col-xl-3"><div class="public-card rounded-4 p-4 h-100"><h4>4. Reserve and manage</h4><p class="text-secondary mb-0">Users reserve medicine while pharmacies manage availability, subscriptions, and reservations.</p></div></div>
    </section>
@endsection
