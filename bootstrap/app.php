<?php

use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\CheckUserAcitve;
use App\Http\Middleware\CheckUserSubscription;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware untuk check perrmision user
        $middleware->alias([
            'permission' => CheckPermission::class,
            'user.active' => CheckUserAcitve::class,
            'subscription' => CheckUserSubscription::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        $exceptions->render(function (Throwable $e, $request) {
            if (!$request->is('api/*')) {
                return null;
            }

            if (
                $e instanceof AuthenticationException ||
                $e instanceof UnauthorizedHttpException
            ) {
                $previous = $e->getPrevious();

                return match (true) {
                    $previous instanceof TokenExpiredException => response()->json([
                        'statusCode' => 401,
                        'statusMessage' => 'Unauthorized',
                        'statusDescription' => 'Authentication token is expired',
                        'result' => [
                            'errorCode' => '2',
                            'errorMessage' => 'Token expired'
                        ]
                    ], 401),

                    $previous instanceof TokenInvalidException => response()->json([
                        'statusCode' => 401,
                        'statusMessage' => 'Unauthorized',
                        'statusDescription' => 'Authentication token invalid',
                        'result' => [
                            'errorCode' => '3',
                            'errorMessage' => 'Token invalid'
                        ]
                    ], 401),

                    default => response()->json([
                        'statusCode' => 401,
                        'statusMessage' => 'Unauthorized',
                        'statusDescription' => 'Authentication token not provided',
                        'result' => [
                            'errorCode' => '4',
                            'errorMessage' => 'Token not provided'
                        ]
                    ], 401),
                };
            }

            return null;
        });

        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => 'Not Found',
                    'statusDescription' => 'The requested resource was not found on the server',
                    'result' => [
                        'errorCode' => '28',
                        'errorMessage' => 'Data not found'
                    ]
                ], 404);
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => 'Not Found',
                    'statusDescription' => 'The requested resource was not found on the server',
                    'result' => [
                        'errorCode' => '28',
                        'errorMessage' => 'Data not found'
                    ]
                ], 404);
            }
        });
    })
    ->create();
