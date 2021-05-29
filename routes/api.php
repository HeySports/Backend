<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\User\profileController;
use App\Http\Controllers\User\roleController;
use App\Http\Controllers\User\teamController;
use App\Http\Controllers\Match\matchController;
use App\Http\Controllers\Match\detailMatchController;
use App\Http\Controllers\Fields\fieldController;
use App\Http\Controllers\Fields\childFieldController;
use App\Http\Controllers\Notifications\notificationController;
use App\Http\Controllers\Comments\commentMatchController;
use App\Http\Controllers\Comments\commentFieldController;
use App\Http\Controllers\Booking\orderController;
use App\Http\Controllers\Offers\offerController;

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
//
Route::post('/auth/checkUser',[authController::class,'checkUser']);
Route::post('/auth/roles/register', [roleController::class, 'roleRegister']);
// // Profile
Route::get('/user/getProfile',[profileController::class,'getProfile']);
Route::get('/user/getAll',[profileController::class,'getAllUser']);
Route::post ('/user/update/password',[profileController::class,'userChangePassWord']);
Route::put('/user/update/profile',[profileController::class,'userUpdateProfile']);
Route::get('/user/getUser/{id}',[profileController::class,'userGetDetail']);
Route::get('/user/checkPhoneNumber/{phone_number}',[profileController::class,'checkPhoneNumber']);
Route::put('/user/resetPassword',[profileController::class,'resetPassword']);
// //matches
Route::get('/match/getAll',[matchController::class,'getAll']); 
// //search
Route::post('/match/postSearchByText',[matchController::class,'postSearchByText']);
Route::post('/match/postSearchByFilter',[matchController::class,'postSearchByFilter']);
Route::get('/match/histories/get',[matchController::class,'userGetHistoriesSearch']);
Route::post('/match/histories/post',[matchController::class,'userPostHistoriesSearch']);
Route::delete('/match/histories/{id}/delete',[matchController::class,'userDeleteHistoriesSearch']);
// //get list in homepage
Route::get('/match/getListMatchFindOpponent',[matchController::class,'getListMatchFindOpponent']);
Route::get('/match/getListMatchFindMember',[matchController::class,'getListMatchFindMember']);
Route::get('/match/getDetailMatch/{id}',[matchController::class,'getDetailMatch']);  
Route::get('/match/getMatchHistory',[matchController::class,'getMatchHistory']);  
Route::post('/match/postMatch',[matchController::class,'postMatch']);    
Route::delete('/match/deleteMatch/{id}', [matchController::class,'deleteMatch']);   
Route::put('/match/putTimePlay/{id}', [matchController::class,'putTimePlay']); 
Route::put('/match/joinTeamOpponent/{id}', [matchController::class,'putJoiningMatchOpponent']); 
Route::put('/match/putMatch/{id}', [matchController::class,'putMatch']);   
// //detail matches
Route::get('/match/getListMatchOfUser',[matchController::class,'getListMatchOfUser']);
Route::get('/match/getDetailMatchByIdMatch/{id_match}',[detailMatchController::class,'getDetailMatchByIdMatch']); 

Route::post('/match/postDetailMatch',[detailMatchController::class,'postDetailMatch']);    
Route::delete('/match/deleteDetailMatch/{id}', [detailMatchController::class,'deleteDetailMatch']); 
  
// Route::put('/match/putDetailMatch/{id}', [detailMatchController::class,'putDetailMatch']); 

Route::put('/match/putNumOfMember/{id}', [detailMatchController::class,'putNumOfMember']); 
// //fields

Route::get('/field/getListField',[fieldController::class,'getListField']); 
Route::get('/field/getDetailField/{id}',[fieldController::class,'getDetailField']); 
Route::post('/field/postField',[fieldController::class,'postField']);    
Route::delete('/field/deleteField/{id}', [fieldController::class,'deleteField']);   
Route::put('/field/putFieldRating/{id}', [fieldController::class,'putFieldRating']); 

// //child field

Route::get('/field/getChildFieldsByField',[childFieldController::class,'getChildFieldsByField']); 
Route::get('/field/getChildField/{id}',[childFieldController::class,'getChildField']); 
Route::post('/field/postChildField',[childFieldController::class,'postChildField']);    
Route::delete('/field/deleteChildField/{id}', [childFieldController::class,'deleteChildField']);   
Route::put('/field/putChildField/{id}', [childFieldController::class,'putChildField']); 
// //notification
Route::get('/notification/getListNotification',[notificationController::class,'getListNotification']); 
Route::get('/notification/getNotification/{id_user}',[notificationController::class,'getNotification']); 
Route::post('/notification/postNotification',[notificationController::class,'postNotification']);    
Route::delete('/notification/deleteNotification/{id}', [notificationController::class,'deleteNotification']);   
Route::put('/notification/putNotification/{id}', [notificationController::class,'putNotification']); 

//team

Route::get('/team/getTeam/{id}',[teamController::class,'getTeam']); 
Route::get('/team/getListTeam',[teamController::class,'getListTeam']); 
Route::get('/team/getListTeamByUser/{idUser}',[teamController::class,'getListTeamByUser']); 
Route::get('/team/getListUserByTeam/{idTeam}',[teamController::class,'getListUserByTeam']); 
Route::post('/team/postTeam',[teamController::class,'postTeam']);    
Route::delete('/team/deleteTeam/{id}', [teamController::class,'deleteTeam']);   
Route::put('/team/putTeam/{id}', [teamController::class,'putTeam']); 

Route::put('/notification/putStatusNotification/{id}', [notificationController::class,'putStatusNotification']); 
// detail notification by id user
Route::get('/notification/getListNotification',[notificationController::class,'getListNotification']); 
// //comment match
// Route::get('/commentMatch/getAll',[commentMatchController::class,'getAll']); 
Route::get('/commentMatch/getCommentMatchByIdMatch/{id}',[commentMatchController::class,'getCommentMatchByIdMatch']); 
Route::post('/commentMatch/postCommentMatch',[commentMatchController::class,'postCommentMatch']);    
Route::delete('/commentMatch/deleteCommentMatch/{id}', [commentMatchController::class,'deleteCommentMatch']);   
Route::delete('/commentMatch/deleteCommentMatchByIdMatch/{id_match}', [commentMatchController::class,'deleteCommentMatchByIdMatch']);  
Route::put('/commentMatch/putCommentMatch/{id}', [commentMatchController::class,'putCommentMatch']); 
// //
// //comment field
// Route::get('/commentField/getAll',[commentFieldController::class,'getAll']); 
Route::get('/commentField/getCommentFieldByIdField/{id}',[commentFieldController::class,'getCommentFieldByIdField']); 
Route::post('/commentField/postCommentField',[commentFieldController::class,'postCommentField']);
    
Route::delete('/commentField/deleteCommentField/{id}', [commentFieldController::class,'deleteCommentField']);   
Route::delete('/commentField/deleteCommentFieldByIdField/{id_field}', [commentFieldController::class,'deleteCommentFieldByIdField']);  
Route::put('/commentField/putCommentField/{id}', [commentFieldController::class,'putCommentField']); 
//
Route::post('/order/checkTimePlayAvailable',[orderController::class,'checkTimePlayAvailable']); 
Route::put('/order/putOrderStatus/{id}',[orderController::class,'putOrderStatus']); 
Route::put('/order/putOrderMatch/{id}',[orderController::class,'putOrderMatch']);
Route::put('/order/putOrder/{id}',[orderController::class,'putOrder']); 
Route::get('/order/getListOrder',[orderController::class,'getListOrder']); 
Route::get('/order/getAll',[orderController::class,'getAll']); 
Route::get('/order/getOrder/{id}',[orderController::class,'getOrder']);
Route::post('/order/postOrder',[orderController::class,'postOrder']); 
Route::delete('/order/deleteOrder/{id}',[orderController::class,'deleteOrder']); 
// get Price
Route::get('/match/price/{id}/field/byType/{type_field}/and/byTime/{time}',[childFieldController::class,'getPriceByField']);
Route::get('/match/lastMatch', [matchController::class,'getLastMatch']);

// Offer Team 
Route::post('/offers/offerTeam', [offerController::class,'postOfferTeam']);
Route::put('/offers/accept/{id}/offerTeam', [offerController::class,'acceptOfferTeam']);
Route::put('/offers/remove/{id}/offerTeam', [offerController::class,'removeOfferTeam']);
Route::get('/offers/get/{id}/offerTeam', [offerController::class,'getOfferTeam']);
