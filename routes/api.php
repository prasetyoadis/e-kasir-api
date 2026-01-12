<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OutletController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('jwt.auth')->group(function () {
    Route::delete('/auth/logout', [AuthController::class, 'logout']);
    
    Route::middleware(['user.active'])->group(function () {
        Route::post('/subscriptions', [SubscriptionController::class, 'store']);

        Route::middleware(['subscription'])->group(function () {
            Route::get('/users/current', [UserController::class, 'current']);
            
            Route::middleware(['permission'])->group(function () {
                Route::apiResource('/users', UserController::class)
                    ->names([
                        'index'   => 'user.view',
                        'show'    => 'user.view',
                        'store'   => 'user.create',
                        'update'  => 'user.update',
                        'destroy' => 'user.delete',
                    ]);
                Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('user.update');
                Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('user.update');
                Route::apiResource('/roles', RoleController::class)
                    ->names([
                        'index'   => 'role.view',
                        'show'    => 'role.view',
                        'store'   => 'role.create',
                        'update'  => 'role.update',
                        'destroy' => 'role.delete',
                    ]);
                Route::apiResource('/outlets', OutletController::class)
                    ->names([
                        'index'   => 'outlet.view',
                        'show'    => 'outlet.view',
                        'store'   => 'outlet.create',
                        'update'  => 'outlet.update',
                        'destroy' => 'outlet.delete',
                    ]);
                Route::patch('/outlets/{outlet}/deactivate', [UserController::class, 'deactivate'])->name('outlet.update');
                Route::patch('/outlets/{outlet}/activate', [UserController::class, 'activate'])->name('outlet.update');
            });
        });
    });
});