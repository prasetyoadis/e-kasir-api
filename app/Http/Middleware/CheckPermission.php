<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $permission = $request->route()->getName();

        if (!$permission) {
            return response()->json([
                'statusCode' => 403,
                'statusMessage' => 'Forbidden',
                'statusDescription' => 'Permission is not defined',
                'result' => [
                    'errorCode' => '6',
                    'errorMessage' => 'Permission denied'
                ]
            ], 403);
        }

        if (!$user->hasPermission($permission)) {
            return response()->json([
                'statusCode' => 403,
                'statusMessage' => 'Forbidden',
                'statusDescription' => 'User does not have permission to this resource',
                'result' => [
                    'errorCode' => '6',
                    'errorMessage' => 'Permission denied'
                ]
            ], 403);
        }

        return $next($request);
    }
}
