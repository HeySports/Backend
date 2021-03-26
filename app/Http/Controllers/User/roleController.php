<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Role;
use Validator;
class roleController extends Controller
{
    function roleRegister(REQUEST $request){
        $input= $request->all();
        $rules=array(
            'name_role'=> "required|string",
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            $arr = array("message" => $validator->errors()->first(), "data" =>$input);
            return response()->json($arr,400);
        }else{
            $_newRole=new Role();
            $_newRole->name_role=$input['name_role'];
            $_newRole->description=$input['description'];
            $_newRole->save();
            $message="Đăng kí thành công !";
            $response = array('message'=>$message,'data'=>$input, 'error'=>null);
            return  response()->json($response, 200);
        }

    }
}
