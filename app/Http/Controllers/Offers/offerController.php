<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Models\OfferTeam;
use App\Models\User;
use App\Models\TeamDetail;
use App\Models\DetailNotification;
use App\Models\Notification;
use App\Http\Controllers\Match\matchController;
class offerController extends Controller
{
    function postOfferTeam(REQUEST $request){
        $input = $request->all();
            $validator = Validator::make($request->all(), [
            'id_team' => 'required',
        ]);
        $user=auth()->user()->id;
        $checkUser=OfferTeam::where('id_user',$user)->where('id_team', $request->id_team)->get();
        $check=TeamDetail::where('id_user',$user)->get();

         if (count($checkUser)>0) {
            $message="Bạn đã gửi yêu cầu tham gia đội này trước đó hãy chờ xác nhận !";
            $error="Thất Bại";
            $response=array('message'=>$message,'data'=>$input, 'error'=>$error, 'id_user'=>$user);
            return response()->json($response, 400);
         }elseif(count($check)>0){
            $message="Bạn đã có đội trên hệ thống bạn không thể tham gia thêm đội nào nữa !";
            $error="Thất Bại";
            $response=array('message'=>$message,'data'=>$check, 'error'=>$error, 'id_user'=>$user);
            return response()->json($response, 400);
         }elseif($validator->fails()){
             return response()->json($validator->errors(), 422);
         }else{
            $new_offer= new OfferTeam();
            $new_offer->id_user=$user;
            $new_offer->id_team=$request->id_team;
            $new_offer->id_status=1;
            $new_offer->description=$request->description;
            $new_offer->save();

            $_new_notification = new Notification();
            $_new_notification->description = 
            auth()->user()->full_name . 'muốn xin vào đội';
            $_new_notification->type = 1;
            $_new_notification->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $_new_notification->save();
            $data_notification = ['id_user'=> auth()->user()->id, 'id_team'=> $new_offer->id_team, "description"=>$new_offer->description];
            $tokens =[];
            $users=DB::table('team_details')
            ->join('users', 'users.id', '=', 'team_details.id_user')
            ->where('team_details.id_team',$new_offer->id_team)
            ->select('users.id as id', 'users.device_token as device_token')->get();
            foreach ($users as &$value) {
                    $_detail_notification = new DetailNotification();
                    $_detail_notification->id_user = $value->id;
                    $_detail_notification->id_notification = $_new_notification->id;
                    $_detail_notification->status = 0;
                    $_new_notification->save();
                    if($value->device_token != ''){
                        array_push($tokens, $value->device_token);
                    } 
                }
            $notification_Pusher = new matchController();
            $notification_Pusher->pushNotification ($tokens, 'Xin vào đội', $_new_notification->description, $data_notification);
            $message="Bạn đã gửi lời đề nghị tham gia đội thành công !";
            $success="Thành công";
            $response=array('message'=>$message, 'success'=>$success, 'data'=>$new_offer);
            return  response()->json($response);
         }
        }
    function acceptOfferTeam($id){
        $offer=OfferTeam::where('id',$id)->get();
        $new=$offer[0];
        $new->id_status=2;
        $checkUser= TeamDetail::where('id_user',$new->id_user)->where('id_team', $new->id_team)->get();
        if(count($checkUser)>0){
            $message="Người này đã tham gia vào đội của bạn !";
            $error="Thất Bại";
            $response=array('message'=>$message, 'error'=>$error);
            return response()->json($response, 400);
        }else{
        $new->save();
        $new_detail_team=new TeamDetail();
        $new_detail_team->id_user= $new->id_user;
        $new_detail_team->id_team= $new->id_team;
        $new_detail_team->save();
        
        $_new_notification = new Notification();
            $_new_notification->description = 
            auth()->user()->full_name . 'đã chấp nhận cho bạn vào đội';
            $_new_notification->type = 1;
            $_new_notification->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $_new_notification->save();
            $data_notification = ['id_team'=> $new->id_team, "description"=>$_new_notification->description];
            $tokens =[];
            $users=DB::table('users')
            ->where('id',$new->id_user)
            ->select('users.id as id', 'users.device_token as device_token')->get();
            foreach ($users as &$value) {
                    $_detail_notification = new DetailNotification();
                    $_detail_notification->id_user = $value->id;
                    $_detail_notification->id_notification = $_new_notification->id;
                    $_detail_notification->status = 0;
                    $_new_notification->save();
                    if($value->device_token != ''){
                        array_push($tokens, $value->device_token);
                    } 
                }
            $notification_Pusher = new matchController();
            $notification_Pusher->pushNotification ($tokens, 'Chấp nhận vào đội', $_new_notification->description, $data_notification);
        $message="Bạn đã thêm người này vào đội của mình !";
        $success="Thành công";
        $response=array('message'=>$message, 'success'=>$success,'offer'=>$new, 'detail'=>$new_detail_team);
        return  response()->json($response);
        }
    }
        function removeOfferTeam($id){
        $offer=OfferTeam::where('id',$id)->get();
        $new=$offer[0];
        $new->id_status=3;
        $new->save();
        $_new_notification = new Notification();
            $_new_notification->description = 
            auth()->user()->full_name . 'đã từ chối cho bạn vào đội';
            $_new_notification->type = 1;
            $_new_notification->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $_new_notification->save();
            $data_notification = ['id_team'=> $new->id_team, "description"=>$_new_notification->description];
            $tokens =[];
            $users=DB::table('users')
            ->where('id',$new->id_user)
            ->select('users.id as id', 'users.device_token as device_token')->get();
            foreach ($users as &$value) {
                    $_detail_notification = new DetailNotification();
                    $_detail_notification->id_user = $value->id;
                    $_detail_notification->id_notification = $_new_notification->id;
                    $_detail_notification->status = 0;
                    $_new_notification->save();
                    if($value->device_token != ''){
                        array_push($tokens, $value->device_token);
                    } 
                }
            $notification_Pusher = new matchController();
            $notification_Pusher->pushNotification ($tokens, 'Chấp nhận vào đội', $_new_notification->description, $data_notification);
        $message="Bạn đã thêm từ chối đề nghị này !";
        $success="Thành công";
        $response=array('message'=>$message, 'success'=>$success, 'data'=>$new);
        return  response()->json($response);
        }
        function getOfferTeam($id){
        $offers=DB::table('offer_teams')
            ->Where('id_team', $id)->where('id_status',1)
            ->join('users', 'offer_teams.id_user', '=', 'users.id')
            ->select('users.*', 'offer_teams.*')
            ->get();
        $message="Get data thành công !";
        $success="Thành công";
        $response=array('message'=>$message, 'success'=>$success, 'data'=>$offers);
        return  response()->json($response);
        }
    }
