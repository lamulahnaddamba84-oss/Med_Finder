<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.signin');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route($this->dashboardRouteFor(Auth::user()?->role)));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'in:user,pharmacy'],
            'pharmacy_name' => ['required_if:role,pharmacy', 'nullable', 'string', 'max:255'],
            'license' => ['required_if:role,pharmacy', 'nullable', 'string', 'max:255'],
            'address' => ['required_if:role,pharmacy', 'nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            if ($data['role'] === 'pharmacy') {
                Pharmacy::create([
                    'user_id' => $user->id,
                    'name' => $data['pharmacy_name'],
                    'city' => $data['license'],
                    'address' => $data['address'],
                    'phone' => $data['phone'] ?? null,
                    'status' => 'pending',
                ]);
            }

            return $user;
        });

        if ($user->role === 'pharmacy') {
            return redirect()
                ->route('login')
                ->with('status', 'Account created successfully. Please log in to continue.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($this->dashboardRouteFor($user->role));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    public function redirectToDashboard(): RedirectResponse
    {
        return redirect()->route($this->dashboardRouteFor(Auth::user()?->role));
    }

    private function dashboardRouteFor(?string $role): string
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'pharmacy' => 'pharmacy.dashboard',
            default => 'user.dashboard',
        };
    }
}
