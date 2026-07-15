<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminInactivityTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            $lastActivity = session('admin_last_activity_time');

            if ($lastActivity && (time() - $lastActivity > 3600)) { // 3600 seconds = 60 minutes
                Auth::guard('admin')->logout();
                session()->forget('admin_last_activity_time');

                connectify('error', 'Session Expired', 'You have been logged out due to inactivity for 60 minutes.');

                return redirect()->route('login');
            }

            session(['admin_last_activity_time' => time()]);
        }

        return $next($request);
    }
}
