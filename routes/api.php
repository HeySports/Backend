<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\Match\matchController;
use App\Http\Controllers\Fields\fieldController;
use App\Http\Controllers\Fields\childFieldController;

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
Route::post('/user/register', [authController::class, 'register']);
Route::post('/user/login',[authController::class,'login']);
Route::post('/user/forgotPassword',[authController::class,'forgotPassword']);
Route::get('/user/getAll',[authController::class,'getAll']);
// Profile
//matches
Route::get('/match/getAll',[matchController::class,'getAll']); 
Route::get('/match/getMatch/{id}',[matchController::class,'getMatch']); 
Route::post('/match/postMatch',[matchController::class,'postMatch']);    
Route::delete('/match/deleteMatch/{id}', [matchController::class,'deleteMatch']);   
Route::put('/match/putMatch/{id}', [matchController::class,'putMatch']);             
//fields
Route::get('/field/getAll',[fieldController::class,'getAll']); 
Route::get('/field/getField/{id}',[fieldController::class,'getField']); 
Route::post('/field/postField',[fieldController::class,'postField']);    
Route::delete('/field/deleteField/{id}', [fieldController::class,'deleteField']);   
Route::put('/field/putField/{id}', [fieldController::class,'putField']); 
//child fields
Route::get('/field/getChildFieldsByField/{id}',[childFieldController::class,'getChildFieldsByField']); 
Route::get('/field/getChildField/{id}',[childFieldController::class,'getChildField']); 
Route::post('/field/postChildField',[childFieldController::class,'postChildField']);    
Route::delete('/field/deleteChildField/{id}', [childFieldController::class,'deleteChildField']);   
Route::put('/field/putChildField/{id}', [childFieldController::class,'putChildField']); 
