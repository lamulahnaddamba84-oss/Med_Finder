@extends('layouts.public')

@section('title', 'MedFinder | About Us')

@section('content')
    <section class="row g-4 align-items-center">
        <div class="col-lg-6">
            <div class="public-card rounded-5 p-4 p-lg-5 h-100">
                <div class="section-kicker mb-2">About Us</div>
                <h1 class="display-5 fw-bold mb-3">Built to make medicine access calmer, faster, and more transparent</h1>
                <p class="text-secondary mb-3">MedFinder is designed for the everyday reality of searching for medicine across multiple pharmacies. Instead of uncertainty and long movements from place to place, we create one connected space where users can search, compare, and reserve.</p>
                <p class="text-secondary mb-0">For pharmacies, MedFinder offers visibility, structured medicine cataloging, subscription-based onboarding, and a cleaner way to manage reservations from local customers.</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row g-4">
                <div class="col-sm-6"><div class="public-card rounded-4 p-4 h-100"><h4>Trust-first design</h4><p class="text-secondary mb-0">Clear typography, softer clinical tones, and practical information hierarchy.</p></div></div>
                <div class="col-sm-6"><div class="public-card rounded-4 p-4 h-100"><h4>Local pharmacy support</h4><p class="text-secondary mb-0">Independent and growing pharmacies can onboard and reach nearby patients.</p></div></div>
                <div class="col-sm-6"><div class="public-card rounded-4 p-4 h-100"><h4>Responsive everywhere</h4><p class="text-secondary mb-0">Designed for phones, tablets, and desktop workflows without feeling cramped.</p></div></div>
                <div class="col-sm-6"><div class="public-card rounded-4 p-4 h-100"><h4>Real operational value</h4><p class="text-secondary mb-0">Medicine availability, reservations, subscriptions, and pharmacy status all in one platform.</p></div></div>
            </div>
        </div>
    </section>
@endsection
