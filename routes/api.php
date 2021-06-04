<?php
error_reporting(E_ALL);

use App\Http\Controllers\Pay;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController as UserController;
use \App\Http\Controllers\RoleController as RoleController;
use \App\Http\Controllers\AuthController as AuthController;
use \App\Http\Controllers\OrderLinesController as OrderLinesController;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('auth')->middleware(['api','cors'])->group(
    function ($router) {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
        Route::post('/pay', [Pay::class, 'pay']);

    });


Route::prefix('admin')->middleware(['access:manager','cors'])->group(
    function ($router){
        Route::get('/user', [UserController::class, 'index']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::post('/user', [UserController::class, 'store']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);
        Route::put('/user/{id}', [UserController::class, 'update']);

        // route for role
        Route::get('/role',[RoleController::class, 'index']);
        Route::get('/role/{id}', [RoleController::class, 'show']);
        Route::post('/role', [RoleController::class, 'store']);
        Route::delete('/role/{id}',[RoleController::class, 'destroy']);
        Route::put('/role/{id}', [RoleController::class, 'update']);

        Route::get('/product', [ProductController::class, 'index']);
        Route::get('/product/{id}', [ProductController::class, 'show']);
        Route::post('/product', [ProductController::class, 'store']);
        Route::delete('/product/{id}', [ProductController::class, 'destroy']);
        Route::put('/product/{id}', [ProductController::class, 'update']);

        Route::post('/register', [AuthController::class, 'register']);


        Route::get('/order-line', [OrderLinesController::class, 'index']);
        Route::get('/order-line/{id}', [OrderLinesController::class, 'show']);
        Route::post('/order-line', [OrderLinesController::class, 'store']);
        Route::delete('/order-line/{id}', [OrderLinesController::class, 'destroy']);
        Route::put('/order-line/{id}', [OrderLinesController::class, 'update']);
    });

Route::prefix('user')->middleware('cors')->group(function ($router){

    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/product', [ProductController::class, 'index']);

});

Route::prefix('vendor')->middleware(['access:vendor','cors'])->group(
    function ($router){
        Route::put('/order-line/{id}', [OrderLinesController::class, 'accept']);
        Route::post('/order/{id}', [Orders::class, ['accept']]);
        Route::get('/order-line', [OrderLinesController::class, 'index']);
    }
);




