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
    // user get profile
    function getProfile(){
        return response()->json(auth()->user());
     }
     function checkPhoneNumber($phone){
        return response()->json(User::where('phone_numbers', $phone)->get());
     }
     function resetPassword(REQUEST $request){
        $input =$request->all();
        $rules = array(
            'phone_numbers' => 'required|min:10',
            'password'=>"required|string|min:6",
            'confirm_password'=>"required|same:password",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }else{
            $user = User::where('phone_numbers', $request->phone_numbers)->get();
            if(count($user)> 0){
                $user = $user[0];
                $user->password = Hash::make($request->password);
                $user->save();
                $message= "Thay đổi mật khẩu thành công";
                $response=['message'=>$message, 'error'=>null, 'data'=>$user];
                return response()->json($response, 200);
            }
            $message= "Thay đổi mật khẩu thất bại";
            $response=['message'=>$message, 'error'=>'Not found', 'data'=>null];
            return response()->json($response, 404);
        }
     }
     // get all user
    function getAllUser(){
        return response()->json(User::all(), 200);
    }
    // user change password
    function userChangePassword(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required:string|min:6',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required||same:new_password',
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
   // function user update profile 
   function userUpdateProfile(REQUEST $request){
    $input =$request->all();
    $rules = array(
        'phone_numbers' => 'required|min:10|max:11',
        'full_name' => 'required|min:6',
        'email' => 'required|email',
        'address' => 'string|min:10',
        'position_play' => 'string',
        'description' => 'string|max: 255',
    );
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
        return response()->json($validator->errors(),400);
    }else{
        $idUser= auth()->user()->id;
        User::where('id', $idUser)->update(['full_name' => $input['full_name'],'phone_numbers'=>$input['phone_numbers'],'email'=>$input['email'],'address'=>$input['address'],'age'=>$input['age'],'position_play'=>$input['position_play'],'description'=>$input['description']]);
        $message= "Bạn đã cập nhật thông tin thành công!";
        $error= null;
        $response=['message'=>$message, 'error'=>$error, 'data'=>$input];
        return response()->json($response, 200);
    }
   }
   // function  Get detail user
   function userGetDetail($_id){
       try {
           $_users=User::where('id',$_id)->get();
           $message= "Thành công!";
           $response=['message'=>$message,'data'=>$_users];
           return response()->json($response, 200);
       } catch (Exception $error) {
        return response()->json($response, 400);
       }
   }
}