<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MyPageController;
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

// マネージャー権限
Route::prefix('manager')
    ->middleware(['can:manager-higher', 'auth'])->group(function() {
        Route::get('event/past', [EventController::class, 'past'])->name('event.past');
        Route::resource('event', EventController::class);
    });

// ユーザー権限
Route::middleware(['can:user-higher', 'auth'])->group(function() {
    Route::get('dashboard', [ReservationController::class, 'dashboard'])->name('dashboard');
    Route::get('mypage', [MyPageController::class, 'index'])->name('mypage.index');
    Route::get('mypage/{id}', [MyPageController::class, 'show'])->name('mypage.show');
    Route::post('mypage/{id}', [MyPageController::class, 'cancel'])->name('mypage.cancel');
    Route::post('{id}', [ReservationController::class, 'reserve'])->name('event.reserve');
});

// ゲスト権限
Route::get('/', function () {
    return view('calender');
})->name('/');

Route::get('{id}', [ReservationController::class, 'detail'])->name('event.detail');