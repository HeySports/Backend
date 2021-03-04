<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
class authController extends Controller
{
     function myKey(){
        return "DoYouLoveMy_DoanTienThanh_ILoveYou";
     }
    function register(REQUEST $request){
     $full_name=$request->full_name;
     $id_role=$request->id_role;
     $phone= $request->phone_numbers;
     $password=Hash::make($request->password);
     $address=$request->address;
     $requestData=array("full_name"=>$full_name,'phone_number'=>$phone,'password'=>$request->password, 'address'=>$address);
     $checkPhone=User::where('phone_numbers',$phone)->get();
     $checkLengthPhone=strlen($phone);
     if($checkLengthPhone < 10 || $checkLengthPhone > 11){
            $message= "Số điện thoại không đúng !";
            $error="The phone number: ".$phone." does not exist !";
            $response=['message'=>$message, 'error'=>$error,'token'=>null,'data'=>$requestData];
            return response()->json($response, 400);
     }
     elseif(count($checkPhone)==1){
     $message= "Số điện thoại đã tồn tại !";
     $error="The phone number: ".$phone." already exists !";
     $response=['message'=>$message, 'error'=>$error,'token'=>null,'data'=>$requestData];
     return response()->json($response, 400);
     }else{
        $_newUser=new User();
        $_newUser->id_roles=$id_role;
        $_newUser->full_name=$full_name;
        $_newUser->phone_numbers=$phone;
        $_newUser->password=$password;
        $_newUser->address=$address;
        $_newUser->save();
        $id=  $_newUser->id;
        $myKey =$this->myKey();
        $data = array('id_user' => $id);
        $token = JWT::encode($data, $myKey);
        $message="Đăng kí tài khoản thành công !";
        $response = array('message'=>$message,'token' => $token, 'data'=>$requestData, 'error'=>null);
        return  response()->json($response, 200);
   }
     }
   // function Login
   function login(REQUEST $request){
          if (Auth::attempt(['phone_numbers' => $request->phone_number, 'password' => $request->password])) {
               $user = Auth::user();
               $id_user = $user->id;
               $data = array('id_user' => $id_user);
               $myKey = $this->myKey();
               $token = JWT::encode($data, $myKey);
               $message="Đăng nhập thành công !";
               $requestDataSuccess=array('id_role'=>$user->id_roles,'full_name'=>$user->full_name,'phone_number'=>$user->phone_numbers,'password'=>$user->password, 'email'=>$user->email,'address'=>$user->address,'avatar'=>$user->avatar,'age'=>$user->age,'matches_number'=>$user->matches_number,'skill_rating'=>$user->skill_rating,'attitude_rating'=>$user->attitude_rating,'position_play'=>$user->position_play,'description'=>$user->description,'created_at'=>$user->created_at,'updated_at'=>$user->updated_at);
               $response = array('message'=>$message,'token' => $token,'data'=>$requestDataSuccess,'error'=>null);
               return  response()->json($response, 200);
           } else {
               $requestDataError=array('phone_number'=>$request->phone_number,'password'=>$request->password);
               $message="Đăng nhập không thành công !";
               $error="Your phone number or password is incorrect !";
               $response = array('message'=>$message,'token' => null,'data'=>$requestDataError,'error'=>$error);
               return  response()->json($response, 200);
           }
   }
   // function Forgot password 
   function forgotPassword(REQUEST $request){
   return $request->phone_number;
   }
}
