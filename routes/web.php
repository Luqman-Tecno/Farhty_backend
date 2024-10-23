<?php

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

Route::view('/signup', 'livewire.sign-up-screen');

Route::get('/', function () {
    return view('livewire.home-screen');
})->name('home');

Route::get('/offers', function () {
    return view('livewire.offers');
})->name('offers');


Route::get('/discount-offers')->name('discount-offers');
Route::get('/about')->name('about');
Route::get('/orders')->name('orders');
Route::get('/profile')->name('profile');
Route::get('/login', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/login', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
