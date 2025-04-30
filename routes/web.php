<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Shop\ListProducts;
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

Route::get('/', ListProducts::class)->name('shop.index');
Route::get('/cart', ListProducts::class)->name('cart.index');