<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if user exists (admin or pegawai)
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ])->onlyInput('email');
        }

        // Check if user is blocked or inactive
        if ($user->is_blocked) {
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan/diblokir.',
            ])->onlyInput('email');
        }

        // Login WITHOUT remember token - session akan expire setelah 6 jam atau browser ditutup
        if (Auth::attempt($credentials, false)) {
            $request->session()->regenerate();
            
            // Store login timestamp for 6-hour auto-logout
            $request->session()->put('login_time', now()->timestamp);
            
            // Update last login info
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);
            
            return redirect()->intended('/dashboard');
        }


        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    /**
     * Logout dan redirect ke halaman login (untuk fitur Ganti Akun)
     */
    public function switchAccount(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Handle session close when browser/tab closes
     * Called via sendBeacon API
     */
    public function sessionClose(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        return response()->json(['status' => 'logged_out'], 200);
    }
}
