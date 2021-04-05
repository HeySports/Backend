<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use \Firebase\JWT\JWT;
class authController extends Controller
{
    function checkUser(REQUEST $request){
        $phone=$request->phone_numbers;
        $checkPhone=User::where('phone_numbers',$phone)->get();
        if(count($checkPhone)==0){
            $message= "Người dùng chưa tồn tại !";
            $error="The phone number: ".$phone." does not exist !";
            $response=['message'=>$message, 'error'=>$error,'token'=>null,];
            return response()->json($response, 400);
        }else{
            $message= "Người dùng đã tồn tại !";
            $error=null;
            $response=['message'=>$message, 'error'=>$error];
            return response()->json($response, 200);
        }
    }
    // function register
    function register(REQUEST $request){
        $input= $request->all();
        $rules=array(
            'full_name'=> "required|min:8|string",
            'phone_numbers'=>"required|min:10|max:11",
            'password'=>"required|string|min:6",
            'confirm_password'=>"required|same:password"
        );
        $checkPhone=User::where('phone_numbers',$input['phone_numbers'])->get();
        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            $arr = array("message" => $validator->errors()->first(), "data" =>$input);
            return response()->json($arr,400);
        }else{
            $_newUser=new User();
            $_newUser->id_roles=$input['id_roles'];
            $_newUser->full_name=$input['full_name'];
            $_newUser->phone_numbers=$input['phone_numbers'];
            $_newUser->password=Hash::make($input['password']);
            $_newUser->address="Da Nang";
            $_newUser->save();
            $message="Đăng kí tài khoản thành công !";
            $response = array('message'=>$message,'data'=>$input, 'error'=>null);
            return  response()->json($response, 200);
        }
     }
     // function login
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
           'phone_numbers' => 'required',
           'password' => 'required|string|min:6|max:200',
       ]);
        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }elseif (!$token = auth()->attempt($validator->validated())) {
            $message= "Số điện thoại hoặc mật khẩu của bạn không đúng !";
            $error="Your phone number or password incorrect !";
            $response=['message'=>$message, 'error'=>$error];
            return response()->json($response, 400);
        }else{
            return $this->createNewToken($token);
        }  
   }
    // function create a new  token ;
    protected function createNewToken($token){
      return response()->json([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 3600,
          'user' => auth()->user()
      ]);
    }
    // function logout 
    function logout(){
        auth()->logout();
        return response()->json(['message' => 'Bạn đã logout thành công !']);
    }
    // function forgot password 
    function forgotPassword(REQUEST $request){
            $input= $request->all();
            $rules = array(
                'phone_numbers'=>'required',
                'password' => 'required|min:6|string',
                'confirm_password' => 'required|same:password',
            );
            $validator = Validator::make($input, $rules);
            $checkUser= User::where('phone_numbers',$input['phone_numbers'])->get();
            if($validator->fails()){
                $arr = array("message" => $validator->errors()->first(), "data" =>$input);
                return response()->json($arr,400);
            }elseif(count($checkUser)==0){
                $message= "Số điện thoại của bạn không đúng!";
                $error="The phone number incorrect !";
                $response=['message'=>$message, 'error'=>$error];
                return response()->json($response, 400);
            }else{
                $idUser=$checkUser[0]->id;
                User::where('id', $idUser)->update(['password' =>Hash::make($input['password'])]);
                $message= "Bạn đã thay đổi mật khẩu thành công!";
                $error= null;
                $response=['message'=>$message, 'error'=>$error];
                return response()->json($response, 200);
            }
    }
    function getAll(){
        return response()->json(User::all());
    }
}
