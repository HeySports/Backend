<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Team;
use App\Models\TeamComment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
         ->select('users.id', 'users.full_name', 'team_comments.description','team_comments.rating','users.avatar', 'team_comments.created_at')
         ->orderBy('team_comments.created_at', 'desc')
         ->get();
         return  response()->json(['team' => $team, 'userOfTeam'=> $userOfTeam, 'commentOfTeam'=> $commentOfTeam]);
     }
     public function getListTeam()
     {
         $response =  Team::all();
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
                $_new->rating_number=1;
                $_new->address= $address;
                $_new->description=$description;
                $_new->create_by=auth()->user()->id;
                $_new->save();
                $message="Tạo Đội thành công !"; 
                $response = array('message'=>$message,'error'=>null, 'data'=>$_new);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Taọ Team thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
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
              $_new_comment->created_at=Carbon::now();
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
