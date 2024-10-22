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

Route::get('/',function (){
    return view('livewire.home-screen');
} )->name('home');
Route::get('/offers',)->name('offers');
Route::get('/discount-offers', )->name('discount-offers');
Route::get('/about', )->name('about');
Route::get('/orders', )->name('orders');
Route::get('/profile', )->name('profile');
