<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\DetailMatch;
use App\Models\HistoriesSearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Field;
use App\Models\Notification;
use App\Models\DetailNotification;
class matchController extends Controller
{
    function getLastMatch(){
          $_match = Matches::orderBy ('id','DESC')->limit(1)->get();
          $_idMatch = $_match[0]->id +1;
          $_response =array('id_match'=>$_idMatch);
          return response()->json($_response);
    }
    public function getMatchHistory()
    {
        $id_user = auth()->user()->id;
        $response = [];
        $matches =  DB::table('matches')
        ->join('detail_matches', 'matches.id', '=', 'detail_matches.id_match')
        ->where('detail_matches.id_user', '=', $id_user)
        ->where('matches.time_start_play', '<', \DB::raw('NOW()'))
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock','matches.field_name', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->orderBy('matches.time_start_play', 'desc')
        ->get();
        for ($i=0; $i< count($matches); $i++){
            $childFieldPlay = DB::table('child_fields')
            ->join('orders', 'child_fields.id', '=', 'orders.id_child_field')
            ->where('orders.id_match', '=', $matches[$i]->id)
            ->get();
            $fieldPlay= null;
            if(count($childFieldPlay)>0){
                $fieldPlay = Field::where('id', $childFieldPlay[0]->id_field)->get();
            }
            if($matches[$i]->type == 1){
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 0)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sum = 0;
                foreach($memberTeamA as $key=>$value){
                if(isset($value->matches_number))
                    $sum += $value->matches_number;
                }
                if(count($memberTeamA)>0){
                    $matches_number_teamA = $sum/count($memberTeamA);
                }else{
                    $matches_number_teamA = 0;
                }
                
                $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
                $memberTeamB = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sum = 0;
                foreach($memberTeamB as $key=>$value){
                if(isset($value->matches_number))
                    $sum += $value->matches_number;
                }
                if(count($memberTeamB)>0){
                    $matches_number_teamB = $sum/count($memberTeamB);
                }else{
                    $matches_number_teamB = 0;
                }
                
                $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
                if(count($memberTeamA)>0){
                    array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay,'team_a'=>$teamA,'team_b'=>$teamB));
                }
            }else{
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 0)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sumA = 0;
                $sum = 0;
                foreach($memberTeamA as $key=>$value){
                if(isset($value->matches_number))
                    $sumA += $value->matches_number;
                    $sum += $value->numbers_user_added;
                }
                if(count($memberTeamA)>0){
                    $matches_number_teamA = $sumA/count($memberTeamA);
                }else{
                    $matches_number_teamA = 0;
                }
                
                $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
                $memberTeamB = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sumB = 0;
                
                foreach($memberTeamB as $key=>$value){
                if(isset($value->matches_number))
                    $sumB += $value->matches_number;
                    $sum += $value->numbers_user_added;
                }
                if(count($memberTeamB)>0){
                    $matches_number_teamB = $sumB/count($memberTeamB);
                }else{
                    $matches_number_teamB = 0;
                }
                
                $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
                if(count($memberTeamA)>0){
                    array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay, 'missing_members'=>$matches[$i]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
                }
            }
            
        }
        return  response()->json($response);
    }
    
    public function getDetailMatch($id)
    {
        $response = [];
        $matches =  DB::table('matches')
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock','matches.field_name', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->where('matches.id', '=', $id)
        ->get();
        $childFieldPlay = DB::table('child_fields')
        ->join('orders', 'child_fields.id', '=', 'orders.id_child_field')
        ->where('orders.id_match', '=', $matches[0]->id)
        ->get();
        $fieldPlay= null;
        if(count($childFieldPlay)>0){
            $fieldPlay = Field::where('id', $childFieldPlay[0]->id_field)->get();
        }
            $memberTeamA = DB::table('detail_matches')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[0]->id)
            ->where('detail_matches.status_team', '=', 0)
            ->select('users.id','users.phone_numbers', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $sumA = 0;
            $sum = 0;
            foreach($memberTeamA as $key=>$value){
            if(isset($value->matches_number))
                $sumA += $value->matches_number;
                $sum += $value->numbers_user_added;
            }
            if(count($memberTeamA)>0){
                $matches_number_teamA = $sumA/count($memberTeamA);
            }else{
                $matches_number_teamA = 0;
            }
            
            $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
            $teamB =null;
            if($matches[0]->type==1){
                $memberTeamB = DB::table('detail_matches')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[0]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sumB = 0;
                foreach($memberTeamB as $key=>$value){
                if(isset($value->matches_number))
                    $sumB += $value->matches_number;
                }
                if(count($memberTeamB)>0){
                    $matches_number_teamB = $sumB/count($memberTeamB);
                }else{
                    $matches_number_teamB = 0;
                }
                
                $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
            }
            array_push($response,  array('match'=>$matches[0],'field_play'=> $fieldPlay,'missing_members'=>$matches[0]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
        return  response()->json($response[0]);
    }
    public function getListMatchFindMember(){
        $response = [];
        $matches =  DB::table('matches')
        ->where('type', '=', 0)
        ->where('matches.time_start_play', '>', \DB::raw('NOW()'))
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock','matches.field_name', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->orderBy('matches.time_start_play', 'asc')
        ->get();
        for ($i=0; $i< count($matches); $i++){
            $childFieldPlay = DB::table('child_fields')
            ->join('orders', 'child_fields.id', '=', 'orders.id_child_field')
            ->where('orders.id_match', '=', $matches[$i]->id)
            ->get();
            $fieldPlay= null;
            if(count($childFieldPlay)>0){
                $fieldPlay = Field::where('id', $childFieldPlay[0]->id_field)->get();
            }
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 0)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $sumA = 0;
            $sum = 0;
            foreach($memberTeamA as $key=>$value){
            if(isset($value->matches_number))
                $sumA += $value->matches_number;
                $sum += $value->numbers_user_added;
            }
            if(count($memberTeamA)>0){
                $matches_number_teamA = $sumA/count($memberTeamA);
            }else{
                $matches_number_teamA = 0;
            }
            $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
           
            if(count($memberTeamA)>0 && $matches[$i]->type_field*2 > $sum){
                array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay, 'missing_members'=>$matches[$i]->type_field*2 - $sum,'team_a'=>$teamA));
            }
            
        }
        return  response()->json($response);
    }
    public function getListMatchFindOpponent(){
        $response = [];
        $matches =  DB::table('matches')
        ->where('type', '=', 1)
        ->where('matches.time_start_play', '>', \DB::raw('NOW()'))
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock','matches.field_name', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->orderBy('matches.time_start_play', 'asc')
        ->get();
        for ($i=0; $i< count($matches); $i++){
            $childFieldPlay = DB::table('child_fields')
            ->join('orders', 'child_fields.id', '=', 'orders.id_child_field')
            ->where('orders.id_match', '=', $matches[$i]->id)
            ->get();
            $fieldPlay= null;
            if(count($childFieldPlay)>0){
                $fieldPlay = Field::where('id', $childFieldPlay[0]->id_field)->get();
            }
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 0)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $sum = 0;
            foreach($memberTeamA as $key=>$value){
            if(isset($value->matches_number))
                $sum += $value->matches_number;
            }
            if(count($memberTeamA)>0){
                $matches_number_teamA = $sum/count($memberTeamA);
            }else{
                $matches_number_teamA = 0;
            }
            
            $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $sum = 0;
            foreach($memberTeamB as $key=>$value){
            if(isset($value->matches_number))
                $sum += $value->matches_number;
            }
            if(count($memberTeamB)>0){
                $matches_number_teamB = $sum/count($memberTeamB);
            }else{
                $matches_number_teamB = 0;
            }
            
            $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
            if(count($memberTeamA)>0 && count($memberTeamB)===0){
                array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay,'team_a'=>$teamA,'team_b'=>$teamB));
            }
        }
        return  response()->json($response);
    }
    public function getListMatchOfUser(){
        $id_user = auth()->user()->id;
        $response = [];
        $matches =  DB::table('matches')
        ->join('detail_matches', 'matches.id', '=', 'detail_matches.id_match')
        ->where('detail_matches.id_user', '=', $id_user)
        ->where('matches.time_start_play', '>', \DB::raw('NOW()'))
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock','matches.field_name', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->orderBy('matches.time_start_play', 'desc')
        ->get();
        for ($i=0; $i< count($matches); $i++){
            $childFieldPlay = DB::table('child_fields')
            ->join('orders', 'child_fields.id', '=', 'orders.id_child_field')
            ->where('orders.id_match', '=', $matches[$i]->id)
            ->get();
            $fieldPlay= null;
            if(count($childFieldPlay)>0){
                $fieldPlay = Field::where('id', $childFieldPlay[0]->id_field)->get();
            }
            if($matches[$i]->type == 1){
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 0)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sum = 0;
                foreach($memberTeamA as $key=>$value){
                if(isset($value->matches_number))
                    $sum += $value->matches_number;
                }
                if(count($memberTeamA)>0){
                    $matches_number_teamA = $sum/count($memberTeamA);
                }else{
                    $matches_number_teamA = 0;
                }
                
                $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
                $memberTeamB = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sum = 0;
                foreach($memberTeamB as $key=>$value){
                if(isset($value->matches_number))
                    $sum += $value->matches_number;
                }
                if(count($memberTeamB)>0){
                    $matches_number_teamB = $sum/count($memberTeamB);
                }else{
                    $matches_number_teamB = 0;
                }
                
                $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
                if(count($memberTeamA)>0){
                    array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay,'team_a'=>$teamA,'team_b'=>$teamB));
                }
            }else{
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 0)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sumA = 0;
                $sum = 0;
                foreach($memberTeamA as $key=>$value){
                if(isset($value->matches_number))
                    $sumA += $value->matches_number;
                    $sum += $value->numbers_user_added;
                }
                if(count($memberTeamA)>0){
                    $matches_number_teamA = $sumA/count($memberTeamA);
                }else{
                    $matches_number_teamA = 0;
                }
                
                $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
                $memberTeamB = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sumB = 0;
                
                foreach($memberTeamB as $key=>$value){
                if(isset($value->matches_number))
                    $sumB += $value->matches_number;
                    $sum += $value->numbers_user_added;
                }
                if(count($memberTeamB)>0){
                    $matches_number_teamB = $sumB/count($memberTeamB);
                }else{
                    $matches_number_teamB = 0;
                }
                
                $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
                if(count($memberTeamA)>0){
                    array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay, 'missing_members'=>$matches[$i]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
                }
            }
            
        }
        return  response()->json($response);
    }
   
    public function postSearchByText(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'txtSearch' => 'required|max:255',
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }else{
            $response = [];
            $matches =  Matches::where('name_room','=',$request->txtSearch)->get();
            if(count($matches)<=0){
                $matches =DB::table('matches')
                ->where('matches.description', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('matches.name_room', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('matches.type_field', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('matches.address', 'like', '%' . $request->txtSearch . '%')
                ->select('matches.id', 'matches.address', 'matches.name_room', 'matches.lock','matches.field_name', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
                , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
                ->orderBy('matches.time_start_play', 'asc')
                ->get();
            
            }
    
            for ($i=0; $i< count($matches); $i++){
                $childFieldPlay = DB::table('child_fields')
                ->join('orders', 'child_fields.id', '=', 'orders.id_child_field')
                ->where('orders.id_match', '=', $matches[$i]->id)
                ->get();
                $fieldPlay= null;
                if(count($childFieldPlay)>0){
                    $fieldPlay = Field::where('id', $childFieldPlay[0]->id_field)->get();
                }
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 0)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sumA = 0;
                $sum = 0;
                foreach($memberTeamA as $key=>$value){
                if(isset($value->matches_number))
                    $sumA += $value->matches_number;
                    $sum += $value->numbers_user_added;
                }
                if(count($memberTeamA)>0){
                    $matches_number_teamA = $sumA/count($memberTeamA);
                }else{
                    $matches_number_teamA = 0;
                }
                
                $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
                $memberTeamB = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $sumB = 0;
                
                foreach($memberTeamB as $key=>$value){
                if(isset($value->matches_number))
                    $sumB += $value->matches_number;
                    $sum += $value->numbers_user_added;
                }
                if(count($memberTeamB)>0){
                    $matches_number_teamB = $sumB/count($memberTeamB);
                }else{
                    $matches_number_teamB = 0;
                }
                
                $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
                array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay,'missing_members'=>$matches[$i]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
            }
            return  response()->json($response);
         }
    }
    public function postSearchByFilter(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'time_play' => 'required',
            'age_min' => 'required',
            'age_max' => 'required',
            'skill_min' => 'required',
            'skill_max' => 'required',
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }else{
            $response = [];
            $matches =  [];
            
                $matches =DB::table('matches')
                ->whereDate('matches.time_start_play', $request->time_play)
                ->select('matches.id', 'matches.address', 'matches.name_room', 'matches.lock','matches.field_name', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
                , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
                ->orderBy('matches.time_start_play', 'asc')
                ->get();
           
    
            for ($i=0; $i< count($matches); $i++){
                $childFieldPlay = DB::table('child_fields')
                ->join('orders', 'child_fields.id', '=', 'orders.id_child_field')
                ->where('orders.id_match', '=', $matches[$i]->id)
                ->get();
                $fieldPlay= null;
                if(count($childFieldPlay)>0){
                    $fieldPlay = Field::where('id', $childFieldPlay[0]->id_field)->get();
                }
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 0)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
            $sumA = 0;
            $sum = 0;
            foreach($memberTeamA as $key=>$value){
            if(isset($value->matches_number))
                $sumA += $value->matches_number;
                $sum += $value->numbers_user_added;
            }
            if(count($memberTeamA)>0){
                $matches_number_teamA = $sumA/count($memberTeamA);
            }else{
                $matches_number_teamA = 0;
            }
            
            $teamA = array('matches_number'=>$matches_number_teamA, 'members'=>$memberTeamA);
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
   
            ->get();
            $sumB = 0;
            
            foreach($memberTeamB as $key=>$value){
            if(isset($value->matches_number))
                $sumB += $value->matches_number;
                $sum += $value->numbers_user_added;
            }
            if(count($memberTeamB)>0){
                $matches_number_teamB = $sumB/count($memberTeamB);
            }else{
                $matches_number_teamB = 0;
            }
            
            $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
            array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay,'missing_members'=>$matches[$i]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
            }
            return  response()->json($response);
         }
    }
    public function deleteMatch($id)
    {
        $matches = Matches::findOrFail($id);
        if($matches)
        { 
            $matches->delete(); 
        }
        else
          {
            $message="Xóa trận thất bại !";
            $response = array('message'=>$message,'error'=>'Lỗi');
            return  response()->json($response, 400);
          }
        $message="Xóa trận thành công !";
        $response = array('message'=>$message,'error'=>null);
        return  response()->json($response);
    }
    public function postMatch(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'type'=> 'required',
            'name_room' => 'required|max:255',
            'time_start_play' => 'required',
            'price' => 'required',
            'lose_pay' => 'required',
            'type_field' => 'required',
            "field_name"=>'required',
        ]);
        $_checkName= Matches::where('name_room',$request->name_room)->get();
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        elseif( count($_checkName) > 0){
            $message="Tạo trận thất bại !";
            $e="Tên Phòng đã tồn Tại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response, 400);   
        }
        else{
            $id_user=auth()->user()->id;
            $id_field_play=$request->id_field_play;
            $name_room=$request->name_room;
            $field_name=$request->field_name;
            $lock= $request->lock;
            $password=$request->password;
            $time_start_play=$request->time_start_play;
            $time_end_play=$request->time_end_play;
            $description=$request->description;
            $lose_pay=$request->lose_pay;
            $type=$request->type;
            $price=$request->price;
            $type_field=$request->type_field;
            $address=$request->address;
            $id_child_field= $request->id_child_field;
 
            try {
                $_new=new Matches();
                $_new->id_user=auth()->user()->id;
                $_new->name_room=$name_room;
                $_new->lock=$lock;
                $_new->password=$password;
                $_new->field_name=$request->field_name;
                $_new->time_start_play=$time_start_play;
                $_new->time_end_play=Carbon::parse($time_start_play)->addHour();
                $_new->description=$description;
                $_new->lose_pay=$lose_pay;
                $_new->type=$type;
                $_new->price=$price;
                $_new->type_field=$type_field;
                $_new->address=$request->address;
                $_new->save();
                $_new_detail=new DetailMatch();
                $_new_detail->id_user = auth()->user()->id;
                $_new_detail->id_match=$_new->id;
                $_new_detail->status_team = 0;
                if($type === 0){
                    $_new_detail->numbers_user_added=$request->numbers_user_added;
                }
                $_new_detail->team_name=$request->team_name;
                $_new_detail->save();

                $_new_notification = new Notification();
                $_new_notification->description = 
                auth()->user()->full_name . ' đã tạo 1 trận '.$type_field.'vs'.$type_field.' đấu vào lúc '. $time_start_play;
                $_new_notification->type = 1;
                $_new_notification->id_match = $_new->id;
                $_new_notification->created_at = Carbon::now();
                $_new_notification->save();
                $data_notification = ['id_match'=> $_new->id];
                $tokens =[];
                $users = User::all();
                
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
                $this->pushNotification ($tokens, 'Trận đấu mới', $_new_notification->description, $data_notification);
                $message="Tạo trận thành công !";
                $response = array('message'=>$message,'error'=>null,'data'=> $_new , 'id_match'=> $_new->id);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Tạo trận thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
        }
    }
    public function pushNotification ($tokens, $title, $body, $data){
        $fcm_server_key= "AAAAbU1mo1Y:APA91bGGlYQvtRpaNz81-GXpZCzEgn6yZiVOGMyOxO9BtHw9B0v-NpTMP_3fkOoD35ZvgrUrT3yT8RLYRx60emU-NAXIca-_WnsXgDNAjByTvWlL3BUfmrGpgyOOtK4_un-SySdPzkr1";
        $notificationData = [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $title,
                'body' => $body,
                // 'image' => 'https://cdn.shopify.com/s/files/1/1492/1076/products/Traditional_Black_and_White_Football_Ball_32_Panel_Classic_800x.jpg?v=1563121775',
            ],
            'data' => $data
        ];
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:key=' . $fcm_server_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_exec($ch);
        curl_close($ch);
    }
    public function putMatch(REQUEST $request, $id){
        $validator = Validator::make($request->all(), [
            'time_start_play' => 'required',
        ]);
       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $lock= $request->lock;
            $password=$request->password;
            $time_start_play=$request->time_start_play;
            $time_end_play=$request->time_end_play;
            $description=$request->description;
            try {
                $matches =  Matches::where('id',$id)->get();
                $_new= $matches[0];
                $_new->name_room=$name_room;
                $_new->field_name=$field_name;
                $_new->lock=$lock;
                $_new->password=$password;
                $_new->time_start_play=$time_start_play;
                $_new->time_end_play=Carbon::parse($time_start_play)->addHour();
                $_new->description=$description;
                $_new->save();
                $message="Sửa trận thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Sửa trận thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
        }
        
    }
    public function putTimePlay(REQUEST $request, $id){
        $validator = Validator::make($request->all(), [
            'time_start_play' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $time_start_play=$request->time_start_play;
            try {
                $matches =  Matches::where('id',$id)->get();
                $_new= $matches[0];
                $_new->time_start_play=$time_start_play;
                $_new->time_end_play=Carbon::parse($time_start_play)->addHour();
                $_new->save();
                $message="Sửa thời gian thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Sửa thời gian thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
        }
       
    }
    public function putJoiningMatchOpponent(REQUEST $request, $id){
        $validator = Validator::make($request->all(), [
            'team_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            
            try {
                $id_user= auth()->user()->id;
                $checkValid = DetailMatch::where('id_user','=', $id_user)->where('id_match','=',$id)->get();
                if(count($checkValid)>0){
                    $message="Nhận kèo thất bại !";
                    $response = array('message'=>$message,'error'=>'Người dùng đã tham gia trận đấu này');
                    return  response()->json($response, 400);
                }else{

                    $matches =  Matches::where('id',$id)->get();
                    $_new= $matches[0];
                    $_new->save();
                    $users = DB::table('users')
                    ->join('detail_matches', 'detail_matches.id_user', '=', 'users.id')
                    ->where('detail_matches.id_match', '=', $_new->id)
                    ->select('users.id as id', 'users.full_name', 'users.device_token as device_token')
                    ->get();
                    $_new_detail=new DetailMatch();
                    $_new_detail->id_user = auth()->user()->id;
                    $_new_detail->id_match=$_new->id;
                    $_new_detail->status_team = 1;
                    $_new_detail->team_name=$request->team_name;
                    $_new_detail->save();

                    $_new_notification = new Notification();
                    $_new_notification->description = 
                    'Đội '. $request->team_name . ' đã tham trận '.$_new->type_field.'vs'.$_new->type_field.' '.$_new->name_room;
                    $_new_notification->type = 1;
                    $_new_notification->id_match = $_new->id;
                    $_new_notification->created_at = Carbon::now();
                    $_new_notification->save();
                    $data_notification = ['id_match'=> $_new->id];
                    $tokens =[];
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
                    $this->pushNotification ($tokens,  auth()->user()->full_name.' tham gia trận', $_new_notification->description, $data_notification);

                    $message="Nhận kèo thành công!";
                    $response = array('message'=>$message,'error'=>null);
                    return  response()->json($response, 200);
                }
            } catch (Exception $e) {
                $message="Nhận kèo thất bại";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
        }
       
    }
    function userGetHistoriesSearch(){
            $user=auth()->user()->id;
            $list_histories= HistoriesSearch::where('id_user',$user)->get();
            return response()->json($list_histories);
    }
    function userPostHistoriesSearch(REQUEST $request){
            $status=$request->description;
            $checkHistories = HistoriesSearch::where('description',$status)->get();
            $id = auth()->user()->id;
            if(count($checkHistories) > 0){
                $message= "Thêm thất bại !";
                $response = array('message'=>$message,'error'=>'Đã Tồn Tại');
                return  response()->json($response);
            }else{
                $_newHistories= new HistoriesSearch();
                $_newHistories->id_user= $id;
                $_newHistories->description=$status;     
                try {
                $_newHistories->save();
                $message="Thanh Cong !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $error) {
                $message="Thêm thất bại !";
                $response = array('message'=>$message,'error'=>$error);
                return  response()->json($response);
            }
            }
        }
    function userDeleteHistoriesSearch($id){
        $histories = HistoriesSearch::findOrFail($id);
        if($histories){
            $histories->delete();
            $response=array('massage'=>'Thành Công !', 'error'=> null);
            return  response()->json($response);
        }else{
            $response=array('massage'=>'Thất bại !', 'error'=> 'Không tồn tại');
            return  response()->json($response);
        }
        return $histories;
    }
}
