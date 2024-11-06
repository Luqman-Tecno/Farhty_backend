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

Route::get('/', \App\Livewire\HomeScreen::class)->name('home');

Route::get('/offers/{city?}', \App\Livewire\Offers::class)->name('offers');
Route::get('/offers/details/{weddingHall}', \App\Livewire\OfferDetails::class)->name('offers.details');

Route::get('/offers-sale/details/{weddingHall}', \App\Livewire\OfferSaleDetails::class)->name('offers-sale.details');
Route::get('/booking/form/{weddingHall}/{date?}', \App\Livewire\BookingForm::class)
    ->name('booking.form');

Route::get('/booking/create/{weddingHall}',function (){
    return view('bookings.create')->with('weddingHall',request('weddingHall'))->layout('layouts.app');
})->name('booking.create');

Route::get('/offer-sale', \App\Livewire\OfferSale::class)->name('offer.sale');
Route::get('/payment/{booking}', \App\Livewire\PaymentForm::class)->name('payment.form');

Route::get('/discount-offers')->name('discount-offers');
Route::get('/about', App\Livewire\AboutUs::class)->name('about');
Route::get('/orders' , \App\Livewire\UserBookings::class)->name('orders');
Route::get('/profile')->name('profile');
Route::get('/bookings/{booking}', App\Livewire\BookingShow::class)->name('bookings.show');
Route::get('/payments/deposit/{booking}', [\App\Http\Controllers\BookingController::class, 'payDeposit'])->name('payments.deposit');
Route::get('/offers/discount',\App\Livewire\DescoutOffers::class )->name('offers.discount');

Route::get('/bookings/{booking}/invoice', \App\Livewire\BookingInvoice::class)->name('bookings.invoice');

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
