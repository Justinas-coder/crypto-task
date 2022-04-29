<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function(){

    Route::get('/asset/create', [App\Http\Controllers\AssetController::class, 'create'])->name('asset.create');
    Route::post('/asset/store', [App\Http\Controllers\AssetController::class, 'store'])->name('asset.store');
    Route::get('/assets', [App\Http\Controllers\AssetController::class, 'index'])->name('asset.index');
    Route::delete('/asset/{asset}/destroy', [App\Http\Controllers\AssetController::class, 'destroy'])->name('asset.destroy');
    Route::patch('/asset/{asset}/update', [App\Http\Controllers\AssetController::class, 'update'])->name('asset.update');
    Route::get('/asset/{asset}/edit', [App\Http\Controllers\AssetController::class, 'edit'])->name('asset.edit');


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
