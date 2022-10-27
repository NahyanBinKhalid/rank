<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchesController;

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

Auth::routes();

Route::middleware([ 'auth' ])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('searches')->group(function () {
        Route::get('/', [SearchesController::class, 'index'])->name('searches.index');
        Route::get('/create', [SearchesController::class, 'create'])->name('searches.create');
        Route::post('/', [SearchesController::class, 'store'])->name('searches.store');
        Route::prefix('{id}')->group(function () {
            Route::get('/', [SearchesController::class, 'show'])->name('searches.show');
            Route::get('edit', [SearchesController::class, 'edit'])->name('searches.edit');
            Route::put('{id}', [SearchesController::class, 'update'])->name('searches.update');
            Route::delete('{id}', [SearchesController::class, 'destroy'])->name('searches.destroy');
        });
    });
});
