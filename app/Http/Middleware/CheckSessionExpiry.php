<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpiry
{
    /**
     * Handle an incoming request.
     * Auto-logout user after 6 hours from login
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $loginTime = $request->session()->get('login_time');
            
            // If login_time exists, check if 6 hours have passed
            if ($loginTime) {
                $currentTime = now()->timestamp;
                $sixHoursInSeconds = 6 * 60 * 60; // 6 hours = 21600 seconds
                
                // If more than 6 hours have passed since login
                if (($currentTime - $loginTime) > $sixHoursInSeconds) {
                    // Logout user
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    // Redirect to login with message
                    return redirect('/')->with('session_expired', 'Sesi Anda telah berakhir setelah 6 jam. Silakan login kembali.');
                }
            } else {
                // If login_time doesn't exist (old sessions), set it now
                $request->session()->put('login_time', now()->timestamp);
            }
        }
        
        return $next($request);
    }
}
