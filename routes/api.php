<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\User\profileController;

use App\Http\Controllers\User\roleController;
use App\Http\Controllers\Match\matchController;
use App\Http\Controllers\Match\detailMatchController;
use App\Http\Controllers\Fields\fieldController;
use App\Http\Controllers\Fields\childFieldController;
use App\Http\Controllers\Notifications\notificationController;
use App\Http\Controllers\Comments\commentMatchController;
use App\Http\Controllers\Comments\commentFieldController;
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

Route::post('/auth/roles/register', [roleController::class, 'roleRegister']);
// Profile
Route::get('/user/getProfile',[profileController::class,'getProfile']);
Route::get('/user/getAll',[profileController::class,'getAllUser']);
Route::post ('/user/update/password',[profileController::class,'userChangePassWord']);
Route::put('/user/update/profile',[profileController::class,'userUpdateProfile']);

//matches
Route::get('/match/getAll',[matchController::class,'getAll']); 
//search
Route::post('/match/getListMatchSearch',[matchController::class,'getListMatchSearch']);
//get list in homepage
Route::get('/match/getListMatch',[matchController::class,'getListMatch']);
Route::get('/match/getMatch/{id}',[matchController::class,'getMatch']);  
Route::post('/match/postMatch',[matchController::class,'postMatch']);    
Route::delete('/match/deleteMatch/{id}', [matchController::class,'deleteMatch']);   
Route::put('/match/putMatch/{id}', [matchController::class,'putMatch']);   
//detail matches
Route::get('/match/getDetailMatchByIdMatch/{id}',[detailMatchController::class,'getDetailMatchByIdMatch']); 
Route::get('/match/getDetailMatch/{id}',[detailMatchController::class,'getDetailMatch']); 
Route::post('/match/postDetailMatch',[detailMatchController::class,'postDetailMatch']);    
Route::delete('/match/deleteDetailMatch/{id}', [detailMatchController::class,'deleteDetailMatch']);   
Route::put('/match/putDetailMatch/{id}', [detailMatchController::class,'putDetailMatch']); 
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
//notification
Route::get('/notification/getAll',[notificationController::class,'getAll']); 
Route::get('/notification/getNotification/{id}',[notificationController::class,'getNotification']); 
Route::post('/notification/postNotification',[notificationController::class,'postNotification']);    
Route::delete('/notification/deleteNotification/{id}', [notificationController::class,'deleteNotification']);   
Route::put('/notification/putNotification/{id}', [notificationController::class,'putNotification']); 
// detail notification
Route::get('/notification/getNotificationByIdUser/{id}',[notificationController::class,'getNotificationByIdUser']); 
//comment match
Route::get('/commentMatch/getAll',[commentMatchController::class,'getAll']); 
Route::get('/commentMatch/getCommentMatchByIdMatch/{id}',[commentMatchController::class,'getCommentMatchByIdMatch']); 
Route::post('/commentMatch/postCommentMatch',[commentMatchController::class,'postCommentMatch']);    
Route::delete('/commentMatch/deleteCommentMatch/{id}', [commentMatchController::class,'deleteCommentMatch']);   
Route::delete('/commentMatch/deleteCommentMatchByIdMatch/{id}', [commentMatchController::class,'deleteCommentMatchByIdMatch']);  
Route::put('/commentMatch/putCommentMatch/{id}', [commentMatchController::class,'putCommentMatch']); 
//
//comment field
Route::get('/commentField/getAll',[commentFieldController::class,'getAll']); 
Route::get('/commentField/getCommentFieldByIdField/{id}',[commentFieldController::class,'getCommentFieldByIdField']); 
Route::post('/commentField/postCommentField',[commentFieldController::class,'postCommentField']);    
Route::delete('/commentField/deleteCommentField/{id}', [commentFieldController::class,'deleteCommentField']);   
Route::delete('/commentField/deleteCommentFieldByIdField/{id}', [commentFieldController::class,'deleteCommentFieldByIdField']);  
Route::put('/commentField/putCommentField/{id}', [commentFieldController::class,'putCommentField']); 
