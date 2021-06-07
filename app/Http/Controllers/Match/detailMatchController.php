<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Match\matchController;
use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\DetailMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\DetailNotification;
use Carbon\Carbon;
use Validator;
class detailMatchController extends Controller
{
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
                return  response()->json($response, 400);
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
            return  response()->json($response, 400);
        }  
    }
    public function postDetailMatch(REQUEST $request){
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

                $checkValid = DetailMatch::where('id_user','=', $id_user)->where('id_match','=',$id_match)->get();
                if(count($checkValid)>0){
                    $message="Bạn nhận kèo";
                    $response = array('message'=>$message,'error'=>'Người dùng đã tham gia trận đấu này');
                    return  response()->json($response, 400);
                }else{
                    $m = Matches::where('id',$id_match)->get();
                    $m = $m[0];
                    $users = DB::table('users')
                    ->join('detail_matches', 'detail_matches.id_user', '=', 'users.id')
                    ->where('detail_matches.id_match', '=', $m->id)
                    ->select('users.id as id', 'users.full_name', 'users.device_token as device_token')
                    ->get();
                    $_new=new DetailMatch();
                    $_new->id_user=$id_user;
                    $_new->id_match=$id_match;
                    $_new->status_team= 0;
                    
                    $_new->numbers_user_added=$numbers_user_added;
                    $_new->team_name=$team_name;
                    $_new->save();
                    
                    $_new_notification = new Notification();
                    $_new_notification->description = 
                    auth()->user()->full_name . ' đã tham gia trận '.$m->type_field.'vs'.$m->type_field.' '.$m->name_room;
                    $_new_notification->type = 1;
                    $_new_notification->id_match = $_new->id;
                    $_new_notification->created_at = Carbon::now('Asia/Ho_Chi_Minh');
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
                    $notification_Pusher = new matchController();
                    $notification_Pusher->pushNotification ($tokens, 'Thành viên tham gia đội', $_new_notification->description, $data_notification);
    
                    $message="Taọ thành công !";
                    $response = array('message'=>$message,'error'=>null);
                    return  response()->json($response);
                }
            } catch (Exception $e) {
                $message="Taọ thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
        }
    }
    public function putDetailMatch(REQUEST $request, $id){
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
                return  response()->json($sumNumOfPlayer);
            } catch (Exception $e) {
                $message="Taọ thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response, 400);
            }
        }
    }
}
