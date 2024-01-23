<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplyRequestController;
use App\Http\Controllers\TripTicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('trip-ticket.index');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
//    Route::get('/dashboard', function () {
//        return redirect()->route('trip-ticket.index');
//    })->name('dashboard');

    Route::resource('/trip-ticket', TripTicketController::class)
        ->only([
            'index',
            'create',
            'show',
        ]);

    Route::resource('/supply-request', SupplyRequestController::class)
        ->only([
            'index',
            'create',
            'show',
        ]);

    Route::get('/reports', ReportController::class)->name('report.index');
});
