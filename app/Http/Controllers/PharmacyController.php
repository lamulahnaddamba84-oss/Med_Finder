<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PharmacyController extends Controller
{
    public function dashboard()
    {
        $hasPharmacies = Schema::hasTable('pharmacies');
        $hasMedicines = Schema::hasTable('medicines');
        $hasReservations = Schema::hasTable('reservations');

        $stats = [
            'pharmacies' => $hasPharmacies ? Pharmacy::count() : 0,
            'subscribedPharmacies' => $hasPharmacies ? Pharmacy::where('is_subscribed', true)->count() : 0,
            'pendingPharmacies' => $hasPharmacies ? Pharmacy::where('status', 'pending')->count() : 0,
            'medicines' => $hasMedicines ? Medicine::count() : 0,
            'inStockMedicines' => $hasMedicines ? Medicine::where('stock', '>', 0)->count() : 0,
            'reservations' => $hasReservations ? Reservation::count() : 0,
        ];

        $recentMedicines = $hasMedicines
            ? Medicine::with('pharmacy:id,name')
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $reservationStatuses = $hasReservations
            ? Reservation::selectRaw('status, COUNT(*) as total')->groupBy('status')->orderByDesc('total')->get()
            : collect();

        return view('pharmacy.dashboard', [
            'stats' => $stats,
            'recentMedicines' => $recentMedicines,
            'reservationStatuses' => $reservationStatuses,
        ]);
    }

    public function storeMedicine(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:available,out_of_stock'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        $pharmacy = Pharmacy::where('user_id', $request->user()->id)->first();

        if (! $pharmacy) {
            return back()
                ->withErrors(['medicine' => 'No pharmacy profile was found for this account.'])
                ->withInput();
        }

        $status = $data['quantity'] > 0 ? $data['status'] : 'out_of_stock';

        Medicine::create([
            'pharmacy_id' => $pharmacy->id,
            'name' => $data['name'],
            'category' => $data['category'] ?? 'General',
            'price' => $data['price'],
            'stock' => $data['quantity'],
            'status' => $status,
        ]);

        return redirect()
            ->route('pharmacy.dashboard')
            ->with('status', 'Medicine added successfully.');
    }
}
