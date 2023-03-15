<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\CryptoGatewayController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\PermisionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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
    Route::post('/createorder', [ShopController::class, 'CreateOrder']);
    Route::get('/getorder', [ShopController::class, 'GetOrder']);
    Route::post('/addbrand', [ProductController::class, 'AddBrand']);
    Route::post('/deletebrand', [ProductController::class, 'DeleteBrand']);
    Route::post('/imagestore', [ProductController::class, 'imagestore']);
    Route::post('/updatebrand', [ProductController::class, 'UpdateBrand']);
    Route::post('/addproduct', [ProductController::class, 'AddProduct']);/*  */
    Route::post('/deleteproduct', [ProductController::class, 'DeleteProduct']);
});
//OTP Login
Route::post('/generate', [AuthOtpController::class, 'generate']);
Route::middleware('throttle::verify-limiter')->post('/verify', [AuthOtpController::class, 'verify']);

//CryptoGateway
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/settxid', [CryptoGatewayController::class, 'setTxid']);
});
Route::get('/redirecttotrul', [ShopController::class, 'RedirectToUrl']);
Route::get('/search/{name}', [ShopController::class, 'search']);

#Role and permision
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/createrole', [RoleController::class, 'CreateRole']);
    Route::post('/createpermission', [PermissionController::class, 'CreatePermission']);
    Route::post('/assignpermissiontorole', [RoleController::class, 'AssignPermissionToRole']);
    Route::post('/assignroletouser', [RoleController::class, 'AssignRoleToUser']);
    Route::post('/assignpermissiontouser', [RoleController::class, 'AssignPermissionToUser']);
    Route::get('/roles', [RoleController::class, 'GetRolles']);
    Route::get('/permissions', [RoleController::class, 'GetPermissions']);
    Route::post('/userhasrole', [RoleController::class, 'UserHasRole']);
    Route::post('/rolehaspermission', [RoleController::class, 'RoleHasPermission']);
    Route::post('/userhaspermission', [RoleController::class, 'UserHasPermission']);
    Route::post('/userhasthispermissions', [RoleController::class, 'UserHasThisPermissions']);
    Route::post('/smpr', [RoleController::class, 'SMPR']);
    Route::post('/smpu', [RoleController::class, 'SMPU']);
    Route::post('/revokeuserrole', [RoleController::class, 'RevokeUserRole']);
    Route::post('/deleterole', [RoleController::class, 'DeleteRole']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(['role:Admin'])->get('/test1', [RoleController::class, 'test1']);
    Route::middleware(['role:SuperAdmin'])->get('/test2', [RoleController::class, 'test2']);
    Route::middleware(['role:user'])->put('/test3', [RoleController::class, 'test3']);
    Route::middleware(['role:Tset'])->delete('/test4', [RoleController::class, 'test4']);
});

Route::get('/testgate', [ProductController::class, 'testgate']);
Route::get('/colsort', [ProductController::class, 'colsort']);
