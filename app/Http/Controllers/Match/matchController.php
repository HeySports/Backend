<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matches;

class matchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Matches::all();
    }
    public function getMatch($id)
    {
        $response =  Matches::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getAll()
    {
        return Matches::all();
    }
    public function deleteMatch($id)
    {
        $matches = Matches::findOrFail($id);
        if($matches)
         {  $matches->delete(); }
        else
          {
            $message="Xóa trận thất bại !";
            $response = array('message'=>$message,'error'=>'Lỗi');
            return  response()->json($response);
          }
        $message="Xóa trận thành công !";
        $response = array('message'=>$message,'error'=>null);
        return  response()->json($response);
    }
    public function postMatch(REQUEST $request){
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
        $id_field_play=$request->id_field_play;
        $name_room=$request->name_room;
        $lock= $request->lock;
        $password=$request->password;
        $time_start_play=$request->time_start_play;
        $time_end_play=$request->time_end_play;
        $description=$request->description;
        try {
            $_new=new Matches();
            $_new->id_field_play=$id_field_play;
            $_new->name_room=$name_room;
            $_new->lock=$lock;
            $_new->password=$password;
            $_new->time_start_play=$time_start_play;
            $_new->time_end_play=$time_end_play;
            $_new->description=$description;
            $_new->save();
            $message="Taọ trận thành công !";
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Taọ trận thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }
    }
    public function putMatch(REQUEST $request, $id){
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
        $id_field_play=$request->id_field_play;
        $name_room=$request->name_room;
        $lock= $request->lock;
        $password=$request->password;
        $time_start_play=$request->time_start_play;
        $time_end_play=$request->time_end_play;
        $description=$request->description;
        try {
            $matches =  Matches::where('id',$id)->get();
            $_new= $matches[0];
            $_new->id_field_play=$id_field_play;
            $_new->name_room=$name_room;
            $_new->lock=$lock;
            $_new->password=$password;
            $_new->time_start_play=$time_start_play;
            $_new->time_end_play=$time_end_play;
            $_new->description=$description;
            $_new->save();
            $message="Sửa trận thành công !";
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Sửa trận thất bại !";
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
