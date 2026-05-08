<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower($credentials['login']) === 'admin'
            ? 'admin@perpus.local'
            : $credentials['login'];

        if (! Auth::attempt(['email' => $email, 'password' => $credentials['password']])) {
            return back()
                ->withErrors(['login' => 'Email/username atau password salah.'])
                ->onlyInput('login');
        }

        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectByRole(): RedirectResponse
    {
        return Auth::user()?->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
}
