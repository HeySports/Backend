<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\UserComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
           $_comments = DB::table('user_comments')
           ->join('users', 'user_comments.id_user', '=', 'users.id')
           ->where('user_comments.id_user_commented', '=', $_id)
           ->select('user_comments.id as user_id', 'users.full_name', 'user_comments.description','user_comments.created_at','user_comments.skill_rating','user_comments.attitude_rating')
           ->orderBy('created_at', 'desc')
           ->get();
           $message= "Thành công!";
           $response=['message'=>$message,'data'=>$_users,'comments'=>$_comments];
           return response()->json($response, 200);
       } catch (Exception $error) {
        return response()->json($response, 400);
       }
   }
   function ratingUser(REQUEST $request){
    $validator = Validator::make($request->all(), [
        'description' => 'required',
        'skill_rating' => 'required',
        'attitude_rating' => 'required',
        'id_user_commented' => 'required'
    ]);
     if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
     }else{
         $skill_rating =$request->skill_rating;
         $attitude_rating =$request->attitude_rating;
        try {
            $_new=User::where('id', $request->id_user_commented)->get();
            $_new= $_new[0];
            $_new->skill_rating=($request->skill_rating + $_new->skill_rating*$_new->rating_number)/($_new->rating_number+1);
            $_new->attitude_rating=($request->attitude_rating + $_new->attitude_rating*$_new->rating_number)/($_new->rating_number+1);
            $_new->rating_number=$_new->rating_number+1;
            $_new->save();
            $_new_comment=new UserComment();
            $_new_comment->description=$request->description;
            $_new_comment->id_user_commented=$request->id_user_commented;
            $_new_comment->skill_rating=$request->skill_rating;
            $_new_comment->attitude_rating=$request->attitude_rating;
            $_new_comment->created_at=Carbon::now('Asia/Ho_Chi_Minh');
            $_new_comment->id_user=auth()->user()->id;
            $_new_comment->save();
            $message="Taọ nhận xét thành công !"; 
            $response = array('message'=>$message,'error'=>null, 'comment' => $_new_comment);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Taọ nhận xét  thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response,401);
        }
       
     }
   }
}