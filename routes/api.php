<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('passport')->group(function () {
    Route::post('token', [AuthController::class, 'login']);
    Route::post('token/refresh', [AuthController::class, 'revokeToken']);

    Route::get('tokens', [AuthController::class, 'tokens'])->middleware('auth:api');
    Route::delete('tokens/{token_id}', [AuthController::class, 'revokeToken'])->middleware('auth:api');

    Route::get('clients', [AuthController::class, 'clients']);
    Route::post('clients', [AuthController::class, 'storeClient']);
    Route::put('clients/{client_id}', [AuthController::class, 'updateClient']);
    Route::delete('clients/{client_id}', [AuthController::class, 'destroyClient']);

    Route::get('scopes', [AuthController::class, 'scopes']);

    Route::get('personal-access-tokens', [AuthController::class, 'personalTokens']);
    Route::post('personal-access-tokens', [AuthController::class, 'createPersonalToken']);
    Route::delete('personal-access-tokens/{token_id}', [AuthController::class, 'revokePersonalToken']);
});
