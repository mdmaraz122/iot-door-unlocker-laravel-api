<?php

namespace App\Http\Middleware;

use App\Helpers\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $token = $request->cookie('BackendLogin');
        $data = JWTToken::ReadToken($token);
        $user = $data->userID;
        if (!$user || !$user->can($permission)) {
            return redirect()->route('backend.login');
        }
        return $next($request);
    }
}
