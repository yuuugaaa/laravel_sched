<?php

use App\Http\Controllers\EventController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('manager')
    ->middleware('can:manager-higher')->group(function() {
        Route::get('event/past', [EventController::class, 'past'])->name('event.past');
        Route::resource('event', EventController::class);
    });

Route::middleware('can:user-higher')->group(function() {
    Route::get('index', function() {
        dd('user');
    });
});