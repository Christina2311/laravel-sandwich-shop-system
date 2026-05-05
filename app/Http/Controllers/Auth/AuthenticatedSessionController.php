<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user  = Auth::user();
        $roles = $user->roles()->pluck('role_name')->toArray();

        if (in_array('manager', $roles)) {
            return redirect()->route('manager.dashboard');
        }

        if (in_array('baker', $roles) && in_array('seller', $roles)) {
            return redirect()->route('role.select');
        }

        if (in_array('seller', $roles)) {
            return redirect()->route('seller.dashboard');
        }

        if (in_array('baker', $roles)) {
            return redirect()->route('baker.queue');
        }

        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}