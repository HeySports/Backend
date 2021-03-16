<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class profileController extends Controller
{
    function getProfile(){
        return response()->json(auth()->user());
     }
     function getAllUser(){
        return response()->json(User::all(), 200);
    }
    function userChangePassword(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required:string|min:6',
            'new_password' => 'required|string|min:6',
            'new_password_again' => 'required||same:new_password',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        elseif (!$token = auth()->attempt($validator->validated())) {
            $message= "Mật khẩu của bạn nhập không đúng !";
            $error="Your password incorrect !";
            $response=['message'=>$message, 'error'=>$error];
        return response()->json($response, 400);
        }elseif(! $request->password = auth()->user()->password){
            $message= "Mật khẩu của bạn nhập không đúng!";
            $error="The password incorrect !";
            $response=['message'=>$message, 'error'=>$error];
            return response()->json($response, 400);
        }else{
            if((Hash::check(request('new_password'), Auth::user()->password)) == true){
                $message= "Mật khẩu mới của bạn giống mật khẩu cũ!";
                $error="Please enter a password which is not similar then current password !";
                $response=['message'=>$message, 'error'=>$error];
                return response()->json($response, 400);
            }else{
                $idUser=auth()->user()->id;
                User::where('id', $idUser)->update(['password' =>Hash::make($request->new_password)]);
                $message= "Bạn đã thay đổi mật khẩu thành công!";
                $error= null;
                $response=['message'=>$message, 'error'=>$error];
                return response()->json($response, 200);
            }
        }
   }

}
