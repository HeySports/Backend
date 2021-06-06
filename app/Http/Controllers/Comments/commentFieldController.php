<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommentField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class commentFieldController extends Controller
{
    public function getCommentField($id)
    {
        $response =  CommentField::where('id',$id)
        ->get();
        return  response()->json($response[0]);
    }
    public function getAll()
    {
        return CommentField::all();
    }
    public function getCommentFieldByIdField($id){

        $response =  DB::table('comments_field')
        ->join('users', 'comments_field.id_user', '=', 'users.id')
        ->where('comments_field.id_field', '=', $id)
        ->select('comments_field.id','comments_field.id_user', 'users.full_name', 'comments_field.description','comments_field.rating','comments_field.created_at','comments_field.updated_at')
        ->orderBy('created_at', 'desc')
        ->get();
        return  response()->json($response);
    }
    public function deleteCommentField($id)
    {
        $CommentField = CommentField::findOrFail($id);
        if($CommentField)
         {  $CommentField->delete(); }
        else
          {
            $message="Xóa thất bại !";
            $response = array('message'=>$message,'error'=>'Lỗi');
            return  response()->json($response);
          }
        $message="Xóa thành công !";
        $response = array('message'=>$message,'error'=>null);
        return  response()->json($response);
    }
    public function postCommentField(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'id_field' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
        $id_field=$request->id_field;
        $description=$request->description;
        $id_user=auth()->user()->id;
        try {
            $_new=new CommentField();
            $_new->id_field=$id_field;
            $_new->description=$description;
            $_new->rating=$request->rating;
            $_new->id_user=$id_user;
            $_new->save();
            $message="Taọ thành công !";
            $response = array('message'=>$message,'error'=>null, 'commentField'=>$_new);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Taọ thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }
    }
    }
    public function putCommentField(REQUEST $request, $id){
        $validator = Validator::make($request->all(), [
            'id_field' => 'required',
            'description' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_field=$request->id_field;
            $description=$request->description;
            $id_user=auth()->user()->id;
            try {
                $response =  CommentField::where('id',$id)->get();
                $_new= $response[0];
                $_new->id_field=$id_field;
                $_new->description=$description;
                $_new->id_user=$id_user;
                $_new->save();
                $message="Sửa thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Sửa thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
        }
    }
}
