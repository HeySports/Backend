<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\User\profileController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Auth
Route::post('/auth/register', [authController::class, 'register']);
Route::post('/auth/login',[authController::class,'login']);
Route::get('/auth/logout',[authController::class,'logout']);
Route::put('/auth/forgotPassword',[authController::class,'forgotPassword']);
Route::post('/auth/checkUser',[authController::class,'checkUser']);
// Profile
Route::get('/user/getProfile',[profileController::class,'getProfile']);
Route::get('/user/getAll',[profileController::class,'getAllUser']);
Route::post ('/user/update/password',[profileController::class,'userChangePassWord']);
Route::put('/user/update/profile',[profileController::class,'userUpdateProfile']);

