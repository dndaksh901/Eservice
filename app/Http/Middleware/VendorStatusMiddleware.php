<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('vendor')->user();

        if ($user && $user->status === 0) {
            Auth::guard('vendor')->logout(); // Log the vendor out
            return redirect()->route('vendor.login')->with('error', 'Your account has expired. Please contact support.');
        }

        return $next($request);
    }
}
