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
        ->where('detail_notifications.id_user', '=', $user->id)
        ->select('notifications.id', 'detail_notifications.status', 'notifications.description', 'notifications.id_match', 'notifications.type', 'notifications.created_at', 'notifications.updated_at')
        ->orderBy('notifications.created_at', 'desc')
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
        
       
    }
    public function putStatusNotification(REQUEST $request, $id){
        $user = auth()->user();
        try {
            $response =  DetailNotification::where('id_notification',$id)
            ->where('id_user',$user->id)
            ->get();
            if(count($response)>0){
                $_new= $response[0];
                $_new->status=$request->status;
                $_new->save();
                $message="Sửa status thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response,200);
            }else{
                $message="Sửa status thất bại do fake data!";
                $response = array('message'=>$message,'error'=>'Người dùng không có thông báo này');
                return  response()->json($response,400);
            }
           
        } catch (Exception $e) {
            $message="Sửa thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }
     }
}
