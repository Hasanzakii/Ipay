<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
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
Route::get('/list', [UserController::class, 'List']);
Route::get('/greeting', function () {
    return 'Hello World';
});
Route::get('/buy', [ShopController::class, 'buy']);
Route::any('/payment_callback/{order}/{onlinePayment}', [ShopController::class, 'PaymentCallback'])->name('PaymentCallback');
// Route::post('/shop', [ShopController::class, 'shop']);
