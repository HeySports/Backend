<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommentMatch;
use Illuminate\Support\Facades\DB;
class commentMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
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
        ->select('match_comments.id', 'users.full_name as user_name', 'users.avatar', 'match_comments.description')
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
        // `id_user`, `id_match`, `description`
      
        $id_match=$request->id_match;
        $description=$request->description;
        $id_user=$request->id_user;
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
    public function putCommentMatch(REQUEST $request, $id){
        // `id_user`, `description`, `id_match`
      
        $id_match=$request->id_match;
        $description=$request->description;
        $id_user=$request->id_user;
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
