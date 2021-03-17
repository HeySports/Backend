<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
class notificationController extends Controller
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
    public function getNotification($id)
    {
        $response =  Notification::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getAll()
    {
        return Notification::all();
    }
    public function getNotificationByIdUser($id){

        $response =  DB::table('detail_notifications')
        ->join('notifications', 'notifications.id', '=', 'detail_notifications.id_notification')
        ->join('users', 'detail_notifications.id_user', '=', 'users.id')
        ->where('detail_notifications.id_user', '=', $id)
        ->select('notifications.id', 'notifications.status', 'notifications.description', 'notifications.id_match')
        ->get();
        return  response()->json($response);
    }
    public function deleteNotification($id)
    {
        $Notification = Notification::findOrFail($id);
        if($Notification)
         {  $Notification->delete(); }
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
    public function postNotification(REQUEST $request){
        // `status`, `description`, `id_match`
      
        $id_match=$request->id_match;
        $description=$request->description;
        $status=$request->status;
        try {
            $_new=new Notification();
            $_new->id_match=$id_match;
            $_new->description=$description;
            $_new->status=$status;
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
    public function putNotification(REQUEST $request, $id){
        // `status`, `description`, `id_match`
      
        $id_match=$request->id_match;
        $description=$request->description;
        $status=$request->status;
        try {
            $response =  Notification::where('id',$id)->get();
            $_new= $response[0];
            $_new->id_match=$id_match;
            $_new->description=$description;
            $_new->status=$status;
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
