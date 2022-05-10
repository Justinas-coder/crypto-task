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




Route::get('/assets', [ApiAssetController::class, 'index']);
Route::get('/assets/total', [ApiAssetController::class, 'showTotalSum']);
Route::post('/assets', [ApiAssetController::class, 'store']);
Route::delete('/assets', [ApiAssetController::class, 'delete']);




