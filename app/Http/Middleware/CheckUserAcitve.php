<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAcitve
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        # is yser active
        if (!$user->isActive()) {
            return response()->json([
                'statusCode' => 403,
                'statusMessage' => 'Forbidden',
                'statusDescription' => 'User does not have permission to access this resource',
                'result' => [
                    'errorCode' => '7',
                    'errorMessage' => 'Account is inactive'
                ]
            ], 403);
        }

        return $next($request);
    }
}
