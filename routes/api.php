<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\CryptoGatewayController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/getuser', [AuthOtpController::class, 'GetUser']);
    Route::post('/skip', [AuthOtpController::class, 'Skip']);
    Route::post('/logout', [AuthOtpController::class, 'Logout']);
    Route::post('/updateuser', [AuthOtpController::class, 'UpdateUser']);
});

//Shop
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/getbrand', [ShopController::class, 'brands']);
    Route::post('/productofbrands', [ShopController::class, 'ProductOfBrands']);
    Route::post('/addbrand', [ProductController::class, 'AddBrand']);
    Route::post('/deletebrand', [ProductController::class, 'DeleteBrand']);
    Route::post('/imagestore', [ProductController::class, 'imagestore']);
    Route::post('/createorder', [ShopController::class, 'CreateOrder']);
    Route::get('/getorder', [ShopController::class, 'GetOrder']);
    Route::post('/updatebrand', [ProductController::class, 'UpdateBrand']);
    Route::post('/addproduct', [ProductController::class, 'AddProduct']);/*  */
    Route::post('/deleteproduct', [ProductController::class, 'DeleteProduct']);
});
//OTP Login
Route::post('/generate', [AuthOtpController::class, 'generate']);
Route::post('/verify', [AuthOtpController::class, 'verify']);

//CryptoGateway
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/settxid', [CryptoGatewayController::class, 'setTxid']);
});
Route::get('/redirecttotrul', [ShopController::class, 'RedirectToUrl']);
Route::get('/search/{name}', [ShopController::class, 'search']);
