<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommentField;
use Illuminate\Support\Facades\DB;
class commentFieldController extends Controller
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
    public function getCommentField($id)
    {
        $response =  CommentField::where('id',$id)->get();
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
        ->select('comments_field.id', 'users.full_name as user_name', 'comments_field.description')
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
        // `id_user`, `id_field`, `description` 
        $id_field=$request->id_field;
        $description=$request->description;
        $id_user=$request->id_user;
        try {
            $_new=new CommentField();
            $_new->id_field=$id_field;
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
    public function putCommentField(REQUEST $request, $id){
        // `id_user`, `description`, `id_field`
      
        $id_field=$request->id_field;
        $description=$request->description;
        $id_user=$request->id_user;
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
