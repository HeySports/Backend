<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matches;
use Illuminate\Support\Facades\DB;
class matchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Matches::all();
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
<<<<<<< HEAD
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
=======
    public function getListMatch(){
        $response = [];
        $matches = Matches::all();
>>>>>>> 3c55da9a27972d6ba5bcc8def6d6de4d19926aed
        for ($i=0; $i< count($matches); $i++){
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 1)
<<<<<<< HEAD
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
=======
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added')
>>>>>>> 3c55da9a27972d6ba5bcc8def6d6de4d19926aed
            ->get();
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 2)
<<<<<<< HEAD
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
=======
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added')
>>>>>>> 3c55da9a27972d6ba5bcc8def6d6de4d19926aed
            ->get();
            array_push($response,  array('match'=>$matches[$i],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
        }
        return  response()->json($response);
    }
    public function getListMatchSearch(REQUEST $request){
        $response = [];
        $matches =  Matches::where('name_room',$request->txtSearch)->get();
        if(count($matches)<=0){
            $matches =DB::table('matches')
            ->join('fields', 'matches.id_field_play', '=', 'fields.id')
            ->join('detail_matches', 'detail_matches.id_match', '=', 'matches.id')
            ->where('matches.description', 'like', '%' . $request->txtSearch . '%')
            ->orWhere('matches.name_room', 'like', '%' . $request->txtSearch . '%')
            ->orWhere('fields.name', 'like', '%' . $request->txtSearch . '%')
            ->orWhere('detail_matches.address', 'like', '%' . $request->txtSearch . '%')
            ->select('matches.id', 'matches.id_field_play', 'matches.name_room', 'matches.lock','matches.password','matches.time_start_play'
            , 'matches.time_end_play', 'matches.description'
            , 'matches.created_at', 'matches.updated_at')
            ->get();
        }

        for ($i=0; $i< count($matches); $i++){
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added')
            ->get();
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $matches[$i]->id)
            ->where('detail_matches.status_team', '=', 2)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added')
            ->get();
            array_push($response,  array('match'=>$matches[$i],'team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
        }
        return  response()->json($response);
    }
    public function deleteMatch($id)
    {
        $matches = Matches::findOrFail($id);
        if($matches)
         {  $matches->delete(); }
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
        $id_field_play=$request->id_field_play;
        $name_room=$request->name_room;
        $lock= $request->lock;
        $password=$request->password;
        $time_start_play=$request->time_start_play;
        $time_end_play=$request->time_end_play;
        $description=$request->description;
        try {
            $_new=new Matches();
            $_new->id_field_play=$id_field_play;
            $_new->name_room=$name_room;
            $_new->lock=$lock;
            $_new->password=$password;
            $_new->time_start_play=$time_start_play;
            $_new->time_end_play=$time_end_play;
            $_new->description=$description;
            $_new->save();
            $message="Taọ trận thành công !";
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Taọ trận thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
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
            $_new->time_end_play=$time_end_play;
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
