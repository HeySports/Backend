<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Team;
use App\Models\TeamDetail;
use App\Models\OfferTeam;
use App\Models\User;
use App\Models\DetailNotification;
use App\Models\Notification;
use App\Models\TeamComment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\Match\matchController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class teamController extends Controller
{
  
     public function getTeam($id)
     {
         $team =  Team::where('id',$id)->get();
         $team=$team[0];
         $userOfTeam = DB::table('users')
         ->join('team_details', 'users.id', '=', 'team_details.id_user')
         ->where('team_details.id_team', '=', $team->id)
         ->get();
         $commentOfTeam = DB::table('team_comments')
         ->join('users', 'users.id', '=', 'team_comments.id_user')
         ->where('team_comments.id_team', '=', $team->id)
         ->select('team_comments.id_user','team_comments.id', 'users.full_name', 'team_comments.description','team_comments.rating','users.avatar', 'team_comments.created_at')
         ->orderBy('team_comments.created_at', 'desc')
         ->get();
         return  response()->json(['team' => $team, 'userOfTeam'=> $userOfTeam, 'commentOfTeam'=> $commentOfTeam]);
     }
        public function getTeamDetailByUser()
     { 
         $user= auth()->user()->id;
        $team =  Team::where('create_by',$user)->get();
        $team=$team[0];
         $userOfTeam = DB::table('users')
         ->join('team_details', 'users.id', '=', 'team_details.id_user')
         ->where('team_details.id_team', '=', $team->id)
         ->get();
         $commentOfTeam = DB::table('team_comments')
         ->join('users', 'users.id', '=', 'team_comments.id_user')
         ->where('team_comments.id_team', '=', $team->id)
         ->select('team_comments.id_user','team_comments.id', 'users.full_name', 'team_comments.description','team_comments.rating','users.avatar', 'team_comments.created_at')
         ->orderBy('team_comments.created_at', 'desc')
         ->get();
         return  response()->json(['team' => $team, 'userOfTeam'=> $userOfTeam, 'commentOfTeam'=> $commentOfTeam]);
     }
     public function getListTeam()
     {
         $response =  Team::orderBy('teams.created_at', 'desc')->get();
         return  response()->json($response);
     }
     public function getListUserByTeam($idTeam)
     {
         $response = DB::table('users')
         ->join('team_details', 'users.id', '=', 'team_details.id_user')
         ->where('team_details.id_team', '=', $idTeam)
         ->get();
         return  response()->json($response);
     }
     public function getListTeamByUser($idUser)
     {
         $response = DB::table('teams')
         ->join('team_details', 'teams.id', '=', 'team_details.id_team')
         ->where('team_details.id_user', '=', $idUser)
         ->get();
         return  response()->json($response);
     }
     public function deleteTeam($id)
     {
         $Team = Team::findOrFail($id);
         if($Team)
          {  $Team->delete(); }
         else
           {
             $message="Xóa Team thất bại !";
             $response = array('message'=>$message,'error'=>'Lỗi');
             return  response()->json($response,400);
           }
         $message="Xóa Team thành công !";
         $response = array('message'=>$message,'error'=>null);
         return  response()->json($response);
     }
     public function postTeam(REQUEST $request){
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }else{
            $checker =Team::where('name', $request->name)->get();
            if(count($checker)>0){
                $message="Taọ Team thất bại !";
                $response = array('message'=>$message,'error'=>'Tên đội này đã tồn tại');
                return  response()->json($response, 409);
            }else{
                $name=$request->name;
                $rating=$request->rating;
                $address=$request->address;
                $description=$request->description;
      
                    try {
                        $_new=new Team();
                        $_new->name=$name;
                        if($rating){
                            $_new->rating=$rating;
                        }else{
                            $_new->rating=3;
                        }
                        $_new->create_by=auth()->user()->id;
                        $_new->rating_number=1;
                        $_new->address= $address;
                        $_new->description=$description;
                   
                        $_new->save();
                        $_new_detail=new TeamDetail();
                        $_new_detail->id_user=auth()->user()->id;
                        $_new_detail->id_team= $_new->id;
                        $_new_detail->isCaptain=1;
                         $_new->created_at=Carbon::now('Asia/Ho_Chi_Minh');
                        $_new_detail->save();
    
                        $_new_notification = new Notification();
                        $_new_notification->description = 
                        auth()->user()->full_name . ' đã tạo một 1 đội tên '.$_new->name;
                        $_new_notification->type = 1;
                        $_new_notification->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                        $_new_notification->save();
                        $data_notification = ['id_team'=> $_new->id];
                        $tokens =[];
                        $users = User::where('id','<>',auth()->user()->id)->get();
                        foreach ($users as &$value) {
                            $_detail_notification = new DetailNotification();
                            $_detail_notification->id_user = $value->id;
                            $_detail_notification->id_notification = $_new_notification->id;
                            $_detail_notification->status = 0;
                            $_detail_notification->save();
                            if($value->device_token != ''){
                                array_push($tokens, $value->device_token);
                            } 
                        }
                        $notification_Pusher = new matchController();
                        $notification_Pusher->pushNotification ($tokens, 'Đội tạo mới', $_new_notification->description, $data_notification);
        
                        $message="Taọ Team thành công !"; 
                        $response = array('message'=>$message,'error'=>null,'user'=>$users, 'data'=> $this->getTeam($_new->id));
                        return  response()->json($response);
                } catch (Exception $e) {
                    $message="Taọ Team thất bại !";
                    $response = array('message'=>$message,'error'=>$e);
                    return  response()->json($response, 400);
                }
            }
            
           
         }
        
     }
     public function ratingTeam(REQUEST $request){
        $validator = Validator::make($request->all(), [
          'description' => 'required',
          'rating' => 'required',
          'id_team' => 'required'
      ]);
       if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
       }else{
           $rating =$request->rating;
          try {
              $_new=Team::where('id', $request->id_team)->get();
              $_new= $_new[0];
              if($rating){
                  $_new->rating=($request->rating + $_new->rating*$_new->rating_number)/($_new->rating_number+1);
              }
              $_new->rating_number=$_new->rating_number+1;
              $_new->save();
              $_new_comment=new TeamComment();
              $_new_comment->description=$request->description;
              $_new_comment->id_team=$request->id_team;
              $_new_comment->rating=$request->rating;
              $_new_comment->created_at=Carbon::now('Asia/Ho_Chi_Minh');
              $_new_comment->id_user=auth()->user()->id;
              $_new_comment->save();
              $message="Bạn đã nhận xét Thành công!"; 
              $response = array('message'=>$message,'error'=>null, 'comment' => $_new_comment);
              return  response()->json($response);
          } catch (Exception $e) {
              $message="Taọ nhận xét  thất bại !";
              $response = array('message'=>$message,'error'=>$e);
              return  response()->json($response,401);
          }
         
       }
   }
     public function putTeam(REQUEST $request, $id){
          $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }else{
            $name=$request->name;
            $rating=$request->rating;
            $address=$request->address;
            $description=$request->description;
        
            try {
                $_new=Team::where('id', $id)->get();
                $_new= $_new[0];
                $_new->name=$name;
                if($rating){
                    $_new->rating=($request->rating + $_new->rating*$_new->rating_number)/($_new->rating_number);
                }
                $_new->address= $address;
                $_new->description=$description;
           
                $_new->save();
                $message="Tạo Team thành công !"; 
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Tạo Team thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
           
         }
     }
}
