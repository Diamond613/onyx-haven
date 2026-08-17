<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Stops the browser from serving a cached copy of an authenticated page
 * (e.g. via the back/forward button) after the user has logged out.
 * Without this, the nav bar can keep showing "Logout" instead of
 * "Book Now" because the page itself was never re-requested from the server.
 */
class PreventBackHistoryCache
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
