<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Reservation;
use App\Models\User;
use App\Models\search_log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class UserController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $query = trim((string) $request->query('q', ''));

        $hasUsers = Schema::hasTable('users');
        $hasPharmacies = Schema::hasTable('pharmacies');
        $hasMedicines = Schema::hasTable('medicines');
        $hasReservations = Schema::hasTable('reservations');
        $hasSearchLogs = Schema::hasTable('search_logs');

        $stats = [
            'users' => $hasUsers ? User::count() : 0,
            'nearbyPharmacies' => $hasPharmacies ? Pharmacy::where('status', 'approved')->count() : 0,
            'availableMedicines' => $hasMedicines ? Medicine::where('stock', '>', 0)->count() : 0,
            'myReservations' => $hasReservations ? Reservation::where('user_id', $user->id)->count() : 0,
        ];

        $featuredMedicines = $hasMedicines
            ? Medicine::with('pharmacy:id,name,city')
                ->whereHas('pharmacy', fn ($builder) => $builder->where('status', 'approved'))
                ->where('stock', '>', 0)
                ->orderByDesc('stock')
                ->take(6)
                ->get()
            : collect();

        $searchResults = collect();

        if ($hasMedicines && $query !== '') {
            $searchResults = Medicine::with('pharmacy:id,name,city,status')
                ->whereHas('pharmacy', fn ($builder) => $builder->where('status', 'approved'))
                ->where(function ($builder) use ($query) {
                    $builder->where('name', 'like', "%{$query}%")
                        ->orWhere('category', 'like', "%{$query}%")
                        ->orWhere('form', 'like', "%{$query}%")
                        ->orWhere('strength', 'like', "%{$query}%");
                })
                ->orderByRaw("CASE WHEN status = 'available' AND stock > 0 THEN 0 ELSE 1 END")
                ->orderByDesc('stock')
                ->limit(8)
                ->get();

            if ($hasSearchLogs) {
                search_log::create([
                    'search_query' => $query,
                    'user_id' => $user->id,
                    'is_found' => $searchResults->isNotEmpty(),
                ]);
            }
        }

        $featuredPharmacies = $hasPharmacies
            ? Pharmacy::where('status', 'approved')
                ->orderByDesc('is_subscribed')
                ->latest()
                ->take(5)
                ->get()
            : collect();

        $myReservations = $hasReservations
            ? Reservation::with(['medicine:id,name', 'pharmacy:id,name,city'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $notifications = $myReservations
            ->take(4)
            ->map(function (Reservation $reservation) {
                $status = str_replace('_', ' ', $reservation->status);
                $statusLabel = ucfirst($status);
                $type = match ($reservation->status) {
                    'fulfilled' => 'success',
                    'confirmed' => 'primary',
                    'cancelled' => 'danger',
                    default => 'warning',
                };

                return [
                    'title' => $statusLabel . ' reservation',
                    'message' => ($reservation->medicine?->name ?? 'Medicine')
                        . ' at '
                        . ($reservation->pharmacy?->name ?? 'the selected pharmacy'),
                    'time' => $reservation->updated_at,
                    'type' => $type,
                ];
            });

        $stats['notifications'] = $notifications->count();

        return view('user.dashboard', [
            'stats' => $stats,
            'searchQuery' => $query,
            'searchResults' => $searchResults,
            'featuredMedicines' => $featuredMedicines,
            'myReservations' => $myReservations,
            'notifications' => $notifications,
            'featuredPharmacies' => $featuredPharmacies,
        ]);
    }

    public function reserve(Request $request, Medicine $medicine): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $result = $this->createReservation($request, $medicine, $data, 'reservation');

        if ($result !== null) {
            return $result;
        }

        return redirect()
            ->route('user.dashboard', ['q' => $medicine->name])
            ->with('status', 'Medicine reserved successfully. Check My Reservations for the latest status.');
    }

    public function storeOrder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'medicine_id' => ['required', 'integer', 'exists:medicines,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $medicine = Medicine::findOrFail($data['medicine_id']);
        $result = $this->createReservation($request, $medicine, $data, 'order', 'user.dashboard');

        if ($result !== null) {
            return $result;
        }

        return redirect()
            ->route('user.dashboard')
            ->with('status', 'Medicine reserved successfully.');
    }

    private function createReservation(
        Request $request,
        Medicine $medicine,
        array $data,
        string $errorKey,
        ?string $redirectRoute = null
    ): ?RedirectResponse
    {
        if (! Schema::hasTable('reservations')) {
            return $this->reservationErrorResponse($errorKey, 'Reservations are not available yet.', $redirectRoute);
        }

        $medicine->loadMissing('pharmacy');

        if (! $medicine->pharmacy || $medicine->pharmacy->status !== 'approved') {
            return $this->reservationErrorResponse($errorKey, 'This pharmacy is not approved for reservations yet.', $redirectRoute);
        }

        if ($medicine->status !== 'available' || $medicine->stock < $data['quantity']) {
            return $this->reservationErrorResponse($errorKey, 'Requested quantity is not currently available.', $redirectRoute);
        }

        DB::transaction(function () use ($request, $medicine, $data) {
            Reservation::create([
                'user_id' => $request->user()->id,
                'pharmacy_id' => $medicine->pharmacy_id,
                'medicine_id' => $medicine->id,
                'quantity' => $data['quantity'],
                'status' => 'pending',
                'reserved_for' => now()->addDay(),
                'notes' => $data['notes'] ?? null,
            ]);

            $remainingStock = $medicine->stock - $data['quantity'];

            $medicine->forceFill([
                'stock' => $remainingStock,
                'status' => $remainingStock > 0 ? 'available' : 'out_of_stock',
            ])->save();
        });

        return null;
    }

    private function reservationErrorResponse(string $errorKey, string $message, ?string $redirectRoute = null): RedirectResponse
    {
        if ($redirectRoute !== null) {
            return redirect()->route($redirectRoute)->withErrors([$errorKey => $message]);
        }

        return back()->withErrors([$errorKey => $message]);
    }
}
