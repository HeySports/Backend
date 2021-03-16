<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Validator;
use JWTAuth;
class authController extends Controller
{
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
        $message="Đăng kí tài khoản thành công !";
        $response = array('message'=>$message,'data'=>$requestData, 'error'=>null);
        return  response()->json($response, 200);
   }
     }
   public function login(Request $request){
      $validator = Validator::make($request->all(), [
           'phone_numbers' => 'required',
           'password' => 'required|string|min:6',
       ]);
       if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
       }
       if (! $token = auth()->attempt($validator->validated())) {
           return response()->json(['error' => 'Unauthorized'], 401);
       }
       return $this->createNewToken($token);
   }
   // function create a new  token ;
   protected function createNewToken($token){
      return response()->json([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60,
          'user' => auth()->user()
      ]);
  }
  // function logout 
  function logout(){
   auth()->logout();
   return response()->json(['message' => 'Bạn đã logout thành công !']);
  }
  }
