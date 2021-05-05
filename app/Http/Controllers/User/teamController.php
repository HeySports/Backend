<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class teamController extends Controller
{
  
     public function getTeam($id)
     {
         $response =  Team::where('id',$id)->get();
         return  response()->json($response[0]);
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
             return  response()->json($response);
           }
         $message="Xóa Team thành công !";
         $response = array('message'=>$message,'error'=>null);
         return  response()->json($response);
     }
     public function postTeam(REQUEST $request){
         //  `name`, `rating`, `add`, `description`

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
                $_new->rating=$rating;
                $_new->address= $address;
                $_new->description=$description;
           
                $_new->save();
                $message="Taọ Team thành công !"; 
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Taọ Team thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
           
         }
        
     }
     public function putTeam(REQUEST $request, $id){
          //  `name`, `rating`, `add`, `description`

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
                $_new->rating=$rating;
                $_new->address= $address;
                $_new->description=$description;
           
                $_new->save();
                $message="Taọ Team thành công !"; 
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Taọ Team thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
           
         }
     }
}
