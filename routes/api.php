<?php

use App\Http\Controllers\Api\ApiAssetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')
    ->group(function () {

        Route::get('/assets', [ApiAssetController::class, 'index']);
        Route::get('/assets/{id}', [ApiAssetController::class, 'showSingleAssetData']);
        Route::get('/assets/total', [ApiAssetController::class, 'showTotalSum']);
        Route::post('/assets', [ApiAssetController::class, 'store']);
        Route::delete('/assets/{id}', [ApiAssetController::class, 'delete']);
        Route::put('/assets/{id}', [ApiAssetController::class, 'update']);
    });







