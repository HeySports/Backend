<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommentMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
class commentMatchController extends Controller
{
    public function getCommentMatch($id)
    {
        $response =  CommentMatch::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getAll()
    {
        return CommentMatch::all();
    }
    public function getCommentMatchByIdMatch($id){

        $response =  DB::table('match_comments')
        ->join('users', 'match_comments.id_user', '=', 'users.id')
        ->where('match_comments.id_match', '=', $id)
        ->select('match_comments.id','users.id', 'users.full_name', 'match_comments.description','match_comments.created_at','match_comments.updated_at')
        ->get();
        return  response()->json($response);
    }
    public function deleteCommentMatch($id)
    {
        $CommentMatch = CommentMatch::findOrFail($id);
        if($CommentMatch)
         {  $CommentMatch->delete(); }
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
    public function deleteCommentMatchByIdMatch($id_match){
        try{
            $response=DB::table('match_comments')->where('id_match', $id_match)->delete();
            $message="Xóa thành công !";
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e){
            $message="Xóa thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }  
    }
    public function postCommentMatch(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'id_match' => 'required',
            'description' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
        $id_match=$request->id_match;
        $description=$request->description;
        $id_user=auth()->user()->id;
        try {
            $_new=new CommentMatch();
            $_new->id_match=$id_match;
            $_new->description=$description;
            $_new->id_user=$id_user;
            $_new->save();
            $message="Taọ thành công !";
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Taọ thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }
    } 
    }
    public function putCommentMatch(REQUEST $request, $id){
        $validator = Validator::make($request->all(), [
            'id_match' => 'required',
            'description' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_match=$request->id_match;
            $description=$request->description;
            $id_user=auth()->user()->id;
        try {
            $response =  CommentMatch::where('id',$id)->get();
            $_new= $response[0];
            $_new->id_match=$id_match;
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
