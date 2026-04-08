<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function dashboard()
    {
        $hasUsers = Schema::hasTable('users');
        $hasPharmacies = Schema::hasTable('pharmacies');
        $hasMedicines = Schema::hasTable('medicines');
        $hasReservations = Schema::hasTable('reservations');

        $stats = [
            'users' => $hasUsers ? User::count() : 0,
            'nearbyPharmacies' => $hasPharmacies ? Pharmacy::where('status', 'approved')->count() : 0,
            'availableMedicines' => $hasMedicines ? Medicine::where('stock', '>', 0)->count() : 0,
            'reservations' => $hasReservations ? Reservation::count() : 0,
        ];

        $featuredMedicines = $hasMedicines
            ? Medicine::with('pharmacy:id,name,city')
                ->where('stock', '>', 0)
                ->orderByDesc('stock')
                ->take(6)
                ->get()
            : collect();

        $featuredPharmacies = $hasPharmacies
            ? Pharmacy::where('status', 'approved')
                ->orderByDesc('is_subscribed')
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('user.dashboard', [
            'stats' => $stats,
            'featuredMedicines' => $featuredMedicines,
            'featuredPharmacies' => $featuredPharmacies,
        ]);
    }
}
