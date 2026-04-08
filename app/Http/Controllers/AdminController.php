<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        $hasUsers = Schema::hasTable('users');
        $hasPharmacies = Schema::hasTable('pharmacies');
        $hasMedicines = Schema::hasTable('medicines');
        $hasReservations = Schema::hasTable('reservations');

        $stats = [
            'users' => $hasUsers ? User::count() : 0,
            'pharmacies' => $hasPharmacies ? Pharmacy::count() : 0,
            'subscribedPharmacies' => $hasPharmacies ? Pharmacy::where('is_subscribed', true)->count() : 0,
            'pendingPharmacies' => $hasPharmacies ? Pharmacy::where('status', 'pending')->count() : 0,
            'medicines' => $hasMedicines ? Medicine::count() : 0,
            'reservations' => $hasReservations ? Reservation::count() : 0,
            'activeReservations' => $hasReservations ? Reservation::whereIn('status', ['pending', 'confirmed'])->count() : 0,
            'fulfilledReservations' => $hasReservations ? Reservation::where('status', 'fulfilled')->count() : 0,
        ];

        $medicineCategories = $hasMedicines
            ? Medicine::selectRaw('category, COUNT(*) as total')->groupBy('category')->orderByDesc('total')->get()
            : collect();

        $recentReservations = $hasReservations
            ? Reservation::with(['user:id,name', 'pharmacy:id,name', 'medicine:id,name'])
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $pharmacySnapshot = $hasPharmacies
            ? Pharmacy::select('name', 'city', 'status', 'is_subscribed', 'subscription_plan', 'created_at')
                ->latest()
                ->take(6)
                ->get()
            : collect();

        return view('admin.dashboard', [
            'stats' => $stats,
            'medicineCategories' => $medicineCategories,
            'recentReservations' => $recentReservations,
            'pharmacySnapshot' => $pharmacySnapshot,
        ]);
    }
}
