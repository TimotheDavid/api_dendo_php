<?php
error_reporting(E_ALL);
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController as UserController;
use \App\Http\Controllers\RoleController as RoleController;


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


// route for user
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
