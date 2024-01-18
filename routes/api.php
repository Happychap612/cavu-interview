<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CarParkController;
use App\Http\Controllers\CarPark\SpacesController as CarParkSpacesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SpacesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('car-park')->group(function () {
        Route::get('/', [CarParkController::class, 'index']);

        Route::prefix('{carPark}')->group(function () {
            Route::get('/', [CarParkController::class, 'show']);

            Route::prefix('/spaces')->controller(CarParkSpacesController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{space}', 'show');
            });
        });
    });

    Route::prefix('bookings')->controller(BookingsController::class)->group(function () {
        Route::get('/{booking}', 'show');
        Route::post('/', 'store');
    });

    Route::prefix('customer')->controller(CustomerController::class)->group(function () {
        Route::get('/{customer}', 'show');
        Route::post('/', 'store');
    });


    Route::get('/space/{space}', [SpacesController::class, 'show']);
});
