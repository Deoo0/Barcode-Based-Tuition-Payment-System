<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * Redirect back with flash message if not admin, fallback to home.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->usertype_id != 1) {
            $message = 'You are not authorized to access that page.';
            // If previous URL is different than current, redirect back; otherwise go to home
            try {
                $previous = url()->previous();
                if ($previous && $previous !== url()->current()) {
                    return redirect()->back()->with('error', $message);
                }
            } catch (\Throwable $e) {
                // ignore and fallback to home
            }

            return redirect()->route('home')->with('error', $message);
        }

        return $next($request);
    }
}
