<?php

namespace App\Http\Middleware;

use App\Helpers\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the token from the Authorization header
        $token = $request->cookie('BackendLogin');

        if (!$token) {
            return redirect()->route('backend.login');
        }

        // Decode the token and authenticate the user
        $user = JWTToken::ReadToken($token);

        if ($user == 'unauthorized') {
            return redirect()->route('backend.login');
        }

        // Set the authenticated user for Spatie to use
        auth()->loginUsingId($user->userID);

        return $next($request);
    }
}
