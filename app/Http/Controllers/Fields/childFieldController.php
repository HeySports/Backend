<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildField;
use App\Models\Price_Field;
class childFieldController extends Controller
{
    public function getPriceByField($id_field,$type_field, $time){
       $price=Price_Field::where([['id_field','=',$id_field],['type_field','=',$type_field],['time_start','<=',$time],['time_end','>=',$time]])->get();
       return  response()->json($price);
    }
    public function getChildField($id)
    {
        $response =  ChildField::where('id_field',$id)->get();
        return  response()->json($response);
    }
    public function getChildFieldDetail($id)
    {
        $response =  ChildField::where('id_field',$id)->get();
        return  response()->json($response[0]);
    }
    public function deleteChildField($id)
    {
        $ChildField = ChildField::findOrFail($id);
        if($ChildField)
         {  $ChildField->delete(); }
        else
          {
            $message="Xóa sân thất bại !";
            $response = array('message'=>$message,'error'=>'Lỗi');
            return  response()->json($response);
          }
        $message="Xóa sân thành công !";
        $response = array('message'=>$message,'error'=>null);
        return  response()->json($response);
    }
    public function postChildField(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'id_field' => 'required',
            'name_field' => 'required',
            'type' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_field=$request->id_field;
        $name_field=$request->name_field;
        $type= $request->type;
        $status=$request->status;
        $description=$request->description;
    
        try {
            $_new=new ChildField();
            $_new->id_field=$id_field;
            $_new->name_field=$name_field;
            $_new->type= $type;
            $_new->status=$status;
            $_new->description=$description;
       
            $_new->save();
            $message="Taọ sân thành công !"; 
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Taọ sân thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }
        }
        
       
    }
    public function putChildField(REQUEST $request, $id){
        $validator = Validator::make($request->all(), [
            'id_field' => 'required',
            'name_field' => 'required',
            'type' => 'required'   
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_field=$request->id_field;
            $name_field=$request->name_field;
            $type= $request->type;
            $status=$request->status;
            $description=$request->description;
         
            try {
                $response =  ChildField::where('id',$id)->get();
                $_new= $response[0];
                $_new->id_field=$id_field;
                $_new->name_field=$name_field;
                $_new->type= $type;
                $_new->status=$status;
                $_new->description=$description;
                $_new->save();
                $message="Sửa sân thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Sửa sân thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
        }

       
    }
}
