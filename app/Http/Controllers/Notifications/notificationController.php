<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\DetailNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
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
    public function getListNotification(){
        $user = auth()->user();
        $response =  DB::table('detail_notifications')
        ->join('notifications', 'notifications.id', '=', 'detail_notifications.id_notification')
        ->join('users', 'detail_notifications.id_user', '=', 'users.id')
        ->where('detail_notifications.id_user', '=', $user->id)
        ->select('detail_notifications.id', 'detail_notifications.status', 'notifications.description', 'notifications.id_match', 'notifications.type', 'notifications.created_at', 'notifications.updated_at')
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
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'type' => 'required',
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }else{
            $id_match=$request->id_match;
            $description=$request->description;
            $type=$request->type;
            try {
                $_new=new Notification();
                $_new->id_match=$id_match;
                $_new->description=$description;
                $_new->type=$type;
                $_new->save();
                $message="Taọ thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Taọ thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
         }
        
       
    }
    public function putNotification(REQUEST $request, $id){
        // `type`, `description`, `id_match`
      
        $id_match=$request->id_match;
        $description=$request->description;
        $type=$request->type;
        try {
            $response =  Notification::where('id',$id)->get();
            $_new= $response[0];
            $_new->id_match=$id_match;
            $_new->description=$description;
            $_new->type=$type;
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
    public function putStatusNotification($id){
        // `type`, `description`, `id_match`

        $user = auth()->user();
        try {
            $response =  DetailNotification::where('id_notification',$id)
            ->where('id_user',$user->id)
            ->get();
            $_new= $response[0];
            $_new->status=1;
            $_new->save();
            $message="Sửa status thành công !";
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
