<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailMatch;

class detailMatchController extends Controller
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
    public function getDetailMatch($id)
    {
        $response =  DetailMatch::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getDetailMatchByIdMatch($id)
    {
        $response =  DetailMatch::where('id_match',$id)->get();
        return  response()->json($response);
    }
    public function deleteDetailMatch($id)
    {
        $detailMatch = DetailMatch::findOrFail($id);
        if($detailMatch)
         {  $detailMatch->delete(); }
        else
          {
            $message="Xóa thành viên thất bại !";
            $response = array('message'=>$message,'error'=>'Lỗi');
            return  response()->json($response);
          }
        $message="Xóa thành viên thành công !";
        $response = array('message'=>$message,'error'=>null);
        return  response()->json($response);
    }
    public function postDetailMatch(REQUEST $request){
        //`id_user`, `id_match`, `status_team`, `numbers_user_added`, `address`
        $id_user=$request->id_user;
        $id_match=$request->id_match;
        $status_team= $request->status_team;
        $numbers_user_added=$request->numbers_user_added;
        $address=$request->address;
        try {
            $_new=new DetailMatch();
            $_new->id_user=$id_user;
            $_new->id_match=$id_match;
            $_new->status_team=$status_team;
            $_new->numbers_user_added=$numbers_user_added;
            $_new->address=$address;
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
    public function putDetailMatch(REQUEST $request, $id){
        //`id_user`, `id_match`, `status_team`, `numbers_user_added`, `address`
        $id_user=$request->id_user;
        $id_match=$request->id_match;
        $status_team= $request->status_team;
        $numbers_user_added=$request->numbers_user_added;
        $address=$request->address;
        try {
            $detailMatch =  DetailMatch::where('id',$id)->get();
            $_new= $detailMatch[0];
            $_new->id_user=$id_user;
            $_new->id_match=$id_match;
            $_new->status_team=$status_team;
            $_new->numbers_user_added=$numbers_user_added;
            if($address){
                $_new->address=$address;
            }
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
