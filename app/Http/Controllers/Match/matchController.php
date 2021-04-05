<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\DetailMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
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
        ->join('fields', 'fields.id', '=', 'matches.id_field_play')
        ->join('detail_matches', 'detail_matches.id_match', '=', 'matches.id')
        ->where('detail_matches.id_user', '=', $user->id)
        ->where('lock', '=', 1)
        ->select('matches.id', 'fields.name as field', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->get();
        for ($i=0; $i< count($matches); $i++){
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 2)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            array_push($response,  array('match'=>$matches[$i],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
        }
        return  response()->json($response);
    }
    
    public function getDetailMatch($id)
    {
        $response = [];
        $matches =  DB::table('matches')
            ->join('fields', 'fields.id', '=', 'matches.id_field_play')
            ->select('matches.id', 'fields.name as field', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
            , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
            ->where('matches.id', '=', $id)
            ->get();
     
        $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[0]->id)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
        $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[0]->id)
            ->where('detail_matches.status_team', '=', 2)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            array_push($response,  array('match'=>$matches[0],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
        
        return  response()->json($response[0]);
    }
    public function getAll()
    {
        return Matches::all();
    }
    public function getListMatchFindMember(){
        $response = [];
        $matches =  DB::table('matches')
        ->join('fields', 'fields.id', '=', 'matches.id_field_play')
        ->where('type', '=', 1)
        ->where('lock', '=', 0)
        ->select('matches.id', 'fields.name as field', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->get();
        for ($i=0; $i< count($matches); $i++){
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 2)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            array_push($response,  array('match'=>$matches[$i],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
        }
        return  response()->json($response);
    }
    public function getListMatchFindOpponent(){
        $response = [];
        $matches =  DB::table('matches')
        ->join('fields', 'fields.id', '=', 'matches.id_field_play')
        ->where('type', '=', 0)
        ->where('lock', '=', 0)
        ->select('matches.id', 'fields.name as field', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
        , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
        ->get();
        for ($i=0; $i< count($matches); $i++){
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 2)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            array_push($response,  array('match'=>$matches[$i],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
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
                ->join('fields', 'matches.id_field_play', '=', 'fields.id')
                ->join('detail_matches', 'detail_matches.id_match', '=', 'matches.id')
                ->where('matches.description', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('matches.name_room', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('fields.name', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('fields.address', 'like', '%' . $request->txtSearch . '%')
                ->where('lock', '=', 0)
                ->select('matches.id', 'fields.name as field', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
                , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
                ->get();
            
            }
    
            for ($i=0; $i< count($matches); $i++){
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $memberTeamB = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 2)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                array_push($response,  array('match'=>$matches[$i],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
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
            $matches =  Matches::where('name_room','=',$request->txtSearch)->get();
            if(count($matches)<=0){
                $matches =DB::table('matches')
                ->join('fields', 'matches.id_field_play', '=', 'fields.id')
                ->join('detail_matches', 'detail_matches.id_match', '=', 'matches.id')
                ->where('matches.description', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('matches.name_room', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('fields.name', 'like', '%' . $request->txtSearch . '%')
                ->orWhere('fields.address', 'like', '%' . $request->txtSearch . '%')
                ->where('lock', '=', 0)
                ->select('matches.id', 'fields.name as field', 'matches.name_room', 'matches.lock', 'matches.password','matches.time_start_play', 'matches.time_end_play', 'matches.description'
                , 'matches.lose_pay', 'matches.type', 'matches.price', 'matches.type_field', 'matches.created_at', 'matches.updated_at')
                ->get();
            
            }
    
            for ($i=0; $i< count($matches); $i++){
                $memberTeamA = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 1)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                $memberTeamB = DB::table('detail_matches')
                ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
                ->join('users', 'detail_matches.id_user', '=', 'users.id')
                ->where('detail_matches.id_match', '=', $matches[$i]->id)
                ->where('detail_matches.status_team', '=', 2)
                ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
                , 'detail_matches.team_name')
                ->get();
                array_push($response,  array('match'=>$matches[$i],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
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
            return  response()->json($response);
          }
        $message="Xóa trận thành công !";
        $response = array('message'=>$message,'error'=>null);
        return  response()->json($response);
    }
    public function postMatch(REQUEST $request){
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
        $validator = Validator::make($request->all(), [
            'name_room' => 'required|max:255',
            'time_start_play' => 'required',
            'time_end_play' => 'required',
            'id_field_play' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_field_play=$request->id_field_play;
            $name_room=$request->name_room;
            $lock= $request->lock;
            $password=$request->password;
            $time_start_play=$request->time_start_play;
            $time_end_play=$request->time_end_play;
            $description=$request->description;
            $lose_pay=$request->lose_pay;
            $type=$request->type;
            $price=$request->price;
            $type_field=$request->type_field;
            //
            try {
                $_new=new Matches();
                $_new->id_field_play=$id_field_play;
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
                $_new_detail->status_team = 1;
                $_new_detail->numbers_user_added=$request->numbers_user_added;
                $_new_detail->team_name=$request->team_name;
                $_new_detail->save();

                $message="Taọ trận thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Taọ trận thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
        }
       
    }
    public function putMatch(REQUEST $request, $id){
        //`id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`,
        $id_field_play=$request->id_field_play;
        $name_room=$request->name_room;
        $lock= $request->lock;
        $password=$request->password;
        $time_start_play=$request->time_start_play;
        $time_end_play=$request->time_end_play;
        $description=$request->description;
        try {
            $matches =  Matches::where('id',$id)->get();
            $_new= $matches[0];
            $_new->id_field_play=$id_field_play;
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
            return  response()->json($response);
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
                return  response()->json($response);
            }
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
