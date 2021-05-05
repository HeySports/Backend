<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\DetailMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
class detailMatchController extends Controller
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
    public function putNumOfMember(REQUEST $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'id_match' => 'required',
            'numbers_user_added' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_user=auth()->user()->id;
            $id_match=$request->id_match;
            $numbers_user_added=$request->numbers_user_added;
            try {
                $m = Matches::where('id',$id_match)->get();
                $sumNumOfPlayer = DB::table('detail_matches')
                ->where('id_match', '=', $id_match)
                ->sum('numbers_user_added');
                $sumNumOfPlayer = intval($sumNumOfPlayer);
                if($m[0]->type_field*2 + 6 < $sumNumOfPlayer+ $numbers_user_added){
                    $message="Quá thành viên dự kiến !";
                    $response = array('message'=>$message,'error'=>'Lỗi');
                    return  response()->json($response);
                }else{
                    $_new=DetailMatch::where('id_user','=',$id_user)
                    ->where('id_match', '=', $id_match)
                    ->get();
                    $_new = $_new[0];
                    $_new->numbers_user_added= $_new->numbers_user_added+$numbers_user_added;
                    $_new->save();

                    $message="Thêm thành viên thành công !";
                    $response = array('message'=>$message,'error'=>null);
                    return  response()->json($response);
                }   
            } catch (Exception $e) {
                $message="Taọ thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
        }
    }
    public function getDetailMatch($id)
    {
        $response =  DetailMatch::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getDetailMatchByIdMatch($id)
    {
        $response =  DetailMatch::where('id_match',$id)->get();
        return  response()->json($response);
    }
    public function deleteDetailMatch($id)
    {
        try{
            $detailMatches =
            DetailMatch::where('detail_matches.id_match', $id)
            ->where('detail_matches.id_user', auth()->user()->id)
            ->get();

            foreach ($detailMatches as $detailMatch) {
                $detailMatch->delete();
            }
    
            $message="Xóa thành viên thành công !";
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        }catch (Exception $e){
            $message="Xóa thành viên thất bại !";
            $response = array('message'=>$message,'error'=>'$e');
            return  response()->json($response);
        }
       
    }
    public function postDetailMatch(REQUEST $request){
        //`id_user`, `id_match`, `status_team`, `numbers_user_added`, `team_name`, `created_at`, `updated_at`
        $validator = Validator::make($request->all(), [
            'id_match' => 'required',
            'numbers_user_added' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_user=auth()->user()->id;
            $id_match=$request->id_match;
            $numbers_user_added=$request->numbers_user_added;
            $team_name=$request->team_name;
            try {
                $m = Matches::where('id',$id_match)->get();
                $m = $m[0];
                $_new=new DetailMatch();
                $_new->id_user=$id_user;
                $_new->id_match=$id_match;
                if($m->type==0){
                    $_new->status_team= 2;
                }else{
                    $_new->status_team= 1;
                }
                $_new->numbers_user_added=$numbers_user_added;
                $_new->team_name=$team_name;
                $_new->save();
                $message="Taọ thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Taọ thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
        }
    }
    public function putDetailMatch(REQUEST $request, $id){
        //`id_user`, `id_match`, `status_team`, `numbers_user_added`, `address`
        $validator = Validator::make($request->all(), [
            'id_match' => 'required',
            'numbers_user_added' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $id_user=auth()->user()->id;
            $id_match=$request->id_match;
            $numbers_user_added=$request->numbers_user_added;
            try {
                $m = Matches::where('id',$id_match)->get();
                $sumNumOfPlayer = DB::table('detail_matches')
                ->where('id_match', '=', $id_match)
                ->sum('numbers_user_added');

                // $_new=new DetailMatch();
                // $_new->id_user=$id_user;
                // $_new->id_match=$id_match;
                // if($m[0]->type==0){
                //     $_new->status_team=2;
                // }else{
                //     $_new->status_team=1;
                // }
                // $_new->numbers_user_added=$numbers_user_added;
                // $_new->team_name=$team_name;
                // $_new->save();
    
                // $m = $m[0];
                // $m->lock=1;
                // $m->save();
    
                // $message="Taọ thành công !";
                // $response = array('message'=>$message,'error'=>null);
                return  response()->json($sumNumOfPlayer);
            } catch (Exception $e) {
                $message="Taọ thất bại !";
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
