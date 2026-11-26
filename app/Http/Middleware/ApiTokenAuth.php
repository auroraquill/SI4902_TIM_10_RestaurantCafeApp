<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        $user = $token
            ? User::where('api_token', hash('sha256', $token))->first()
            : null;

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated. Sertakan header Authorization: Bearer <token>.'], 401);
        }

        Auth::setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}