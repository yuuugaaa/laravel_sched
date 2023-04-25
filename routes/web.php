<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
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

// ゲスト用
Route::get('/', function () {
    return view('calender');
});

// 管理者用
Route::prefix('manager')
    ->middleware(['can:manager-higher', 'auth'])->group(function() {
        Route::get('event/past', [EventController::class, 'past'])->name('event.past');
        Route::resource('event', EventController::class);
    });

// 一般ユーザー用
Route::middleware(['can:user-higher', 'auth'])->group(function() {
    Route::get('dashboard', [ReservationController::class, 'dashboard'])->name('dashboard');
});