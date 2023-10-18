<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headers = [...$request->headers];
        $user = User::find(1);

        if (array_key_exists('authorization', $headers)) {
            return $next($request);
            if ($user->getAccessToken($headers['authorization'][0])) {
                return $next($request);
            } else {
                return response()->json(['message' => 'token is wrong.'], 401);
            }
        } else {
            return response()->json(['message' => 'unauthorized'], 401);
        }
    }
}
