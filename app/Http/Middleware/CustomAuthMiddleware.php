<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next){
        $authorizationHeader = $request->header('Authorization');

       // Check if the header exists and starts with 'Bearer'
        if ($authorizationHeader && strpos($authorizationHeader, 'Bearer') === 0) {

            // Extract the token by removing 'Bearer ' prefix
            $token = substr($authorizationHeader, 7);

            // Check if the token is valid
            if (!$this->isValidToken($token)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            // No token
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    private function isValidToken($token){

        $user = User::where('api_token', $token)->first();
        return $user !== null; // Return true only if a user with this token exists
    }
}