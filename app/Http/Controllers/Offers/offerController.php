<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\OfferTeam;
use App\Models\TeamDetail;

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
        $message="Bạn đã thêm người này vào đội của mình !";
        $success="Thành công";
        $response=array('message'=>$message, 'success'=>$error,'offer'=>$new, 'detail'=>$new_detail_team);
        return  response()->json($response);
        }
    }
        function removeOfferTeam($id){
        $offer=OfferTeam::where('id',$id)->get();
        $new=$offer[0];
        $new->id_status=3;
        $new->save();
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
