<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));
        $medicines = collect();

        if ($query !== '' && Schema::hasTable('medicines') && Schema::hasTable('pharmacies')) {
            $medicines = Medicine::with('pharmacy:id,name,city,address')
                ->where(function ($builder) use ($query) {
                    $builder->where('name', 'like', "%{$query}%")
                        ->orWhere('category', 'like', "%{$query}%")
                        ->orWhere('form', 'like', "%{$query}%")
                        ->orWhere('strength', 'like', "%{$query}%");
                })
                ->orderByDesc('stock')
                ->limit(6)
                ->get();
        }

        return view('welcome', [
            'searchQuery' => $query,
            'medicines' => $medicines,
        ]);
    }

    public function howItWorks(): View
    {
        return view('public.how-it-works');
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function contact(): View
    {
        return view('public.contact');
    }
}
