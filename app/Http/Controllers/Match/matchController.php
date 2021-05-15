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
class matchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatchHistory()
    {
        $user = auth()->user();
        $response = [];
        $matches =  DB::table('matches')
        ->where('matches.time_start_play', '<', \DB::raw('NOW()'))
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
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
            array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay, 'missing_members'=>$matches[$i]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
        }
        return  response()->json($response);
    }
    
    public function getDetailMatch($id)
    {
        $response = [];
        $matches =  DB::table('matches')
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
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
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
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
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
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
                $sum += $value->numbers_user_added;
            }
            if(count($memberTeamB)>0){
                $matches_number_teamB = $sumB/count($memberTeamB);
            }else{
                $matches_number_teamB = 0;
            }
            
            $teamB = array('matches_number'=>$matches_number_teamB, 'members'=>$memberTeamB);
            array_push($response,  array('match'=>$matches[0],'field_play'=> $fieldPlay,'missing_members'=>$matches[0]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
        return  response()->json($response[0]);
    }
    public function getListMatchFindMember(){
        $response = [];
        $matches =  DB::table('matches')
        ->where('type', '=', 0)
        ->where('lock', '=', 0)
        ->select('matches.id','matches.name_field' ,'matches.id_user','matches.address', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
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
            if(count($memberTeamA)>0){
                array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay, 'missing_members'=>$matches[$i]->type_field*2 - $sum,'team_a'=>$teamA,'team_b'=>$teamB));
            }
            
        }
        return  response()->json($response);
    }
    public function getListMatchFindOpponent(){
        $response = [];
        $matches =  DB::table('matches')
        ->where('type', '=', 1)
        ->where('lock', '=', 0)
        ->select('matches.id', 'matches.id_user','matches.address', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay','matches.name_field', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->orderBy('created_at', 'desc')
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
            if(count($memberTeamA)>0){
                array_push($response,  array('match'=>$matches[$i],'field_play'=> $fieldPlay,'team_a'=>$teamA,'team_b'=>$teamB));
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
                ->select('matches.id', 'matches.address', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
                , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
                ->orderBy('created_at', 'desc')
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
                ->select('matches.id', 'matches.address', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
                , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
                ->orderBy('created_at', 'desc')
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
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
        $validator = Validator::make($request->all(), [
            'type'=> 'required',
            'name_room' => 'required|max:255',
            'time_start_play' => 'required',
            'price' => 'required',
            'lose_pay' => 'required',
            'type_field' => 'required',
            "name_field"=>'required',
        ]);
        $_checkName= Matches::where('name_room',$request->name_room)->get();
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        elseif( count($_checkName) > 0){
            $message="Taọ trận thất bại !";
            $e="Tên Phòng đã tồn Tại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response, 400);   
        }
        else{
            $id_user=auth()->user()->id;
            $id_field_play=$request->id_field_play;
            $name_room=$request->name_room;
            $name_field=$request->name_field;
            $lock= $request->lock;
            $password=$request->password;
            $time_start_play=$request->time_start_play;
            $time_end_play=$request->time_end_play;
            $description=$request->description;
            $lose_pay=$request->lose_pay;
            $type=$request->type;
            $price=$request->price;
            $type_field=$request->type_field;
            $id_child_field= $request->id_child_field;
 
            try {
                $_new=new Matches();
                $_new->id_user=auth()->user()->id;
                $_new->name_room=$name_room;
                $_new->lock=$lock;
                $_new->password=$password;
                $_new->time_start_play=$time_start_play;
                $_new->time_end_play=Carbon::parse($time_start_play)->addHour();
                $_new->description=$description;
                $_new->lose_pay=$lose_pay;
                $_new->type=$type;
                $_new->price=$price;
                $_new->type_field=$type_field;
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
                $message="Tạo trận thành công !";
                $response = array('message'=>$message,'error'=>null, 'data'=> $_new);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Tạo trận thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
        }
    }
    public function putMatch(REQUEST $request, $id){
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
        $name_room=$request->name_room;
        $lock= $request->lock;
        $password=$request->password;
        $time_start_play=$request->time_start_play;
        $time_end_play=$request->time_end_play;
        $description=$request->description;
        try {
            $matches =  Matches::where('id',$id)->get();
            $_new= $matches[0];
            $_new->name_room=$name_room;
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
    public function putTimePlay(REQUEST $request, $id){
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
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
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
        $validator = Validator::make($request->all(), [
            'status'=> 'required',
            'team_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            
            try {
                $matches =  Matches::where('id',$id)->get();
                $_new= $matches[0];
                $_new->status = $status;
                $_new->save();


                $_new_detail=new DetailMatch();
                $_new_detail->id_user = auth()->user()->id;
                $_new_detail->id_match=$_new->id;
                $_new_detail->status_team = 1;
                $_new_detail->team_name=$request->team_name;
                $_new_detail->save();
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
