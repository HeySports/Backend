<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Matches;
use App\Models\DetailMatch;
use App\Models\Field;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
class orderController extends Controller
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
    public function getListOrder()
    {
        $user = auth()->user();
        $response = [];
        $orders =  DB::table('orders')
        ->join('child_fields', 'child_fields.id', '=', 'orders.id_child_field')
        ->join('matches', 'orders.id_match', '=', 'matches.id')
        ->where('orders.id_user', '=', $user->id)
        ->select('orders.id', 'orders.id_match', 'orders.id_child_field', 'orders.id_user', 'orders.time_start', 
        'orders.time_end', 'orders.description')
        ->get();
        for ($i=0; $i< count($orders); $i++){
            $infoUser = User::where('id',$orders[$i]->id_user)->get();
            $infoField = DB::table('child_fields')
            ->join('fields', 'fields.id', '=', 'child_fields.id_field')
            ->where('child_fields.id', '=', $orders[$i]->id_child_field)
            ->select('child_fields.id', 'fields.name', 'fields.address')
            ->get();
            $infoMatch = [];
            $memberTeamA = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=',  $orders[$i]->id_match)
            ->where('detail_matches.status_team', '=', 1)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            $memberTeamB = DB::table('detail_matches')
            ->join('matches', 'matches.id', '=', 'detail_matches.id_match')
            ->join('users', 'detail_matches.id_user', '=', 'users.id')
            ->where('detail_matches.id_match', '=', $orders[$i]->id_match)
            ->where('detail_matches.status_team', '=', 2)
            ->select('users.id', 'users.full_name', 'users.address', 'users.matches_number', 'users.skill_rating','users.age', 'users.avatar', 'detail_matches.numbers_user_added'
            , 'detail_matches.team_name')
            ->get();
            array_push($infoMatch,  array('team_a'=>$memberTeamA,'team_b'=>$memberTeamB));
            array_push($response,  array('order'=>$orders[$i],'infoUser'=>$infoUser,'infoField'=>$infoField,'infoMatch'=>$infoMatch));
        }
        return  response()->json($response);
    }
    public function getAll()
    {
      
        $response =  Order::all();
        return  response()->json($response);
    }
    public function getOrder()
    {
        
        $response =  Order::where('id_user',$id)->get();
        return  response()->json($response);
    }
    public function deleteOrder($id)
    {
        $Order = Order::findOrFail($id);
        if($Order)
         {  $Order->delete(); }
        else
          {
            $message="Xóa sân thất bại !";
            $response = array('message'=>$message,'error'=>'Lỗi');
            return  response()->json($response);
          }
        $message="Xóa sân thành công !";
        $response = array('message'=>$message,'error'=>null);
        return  response()->json($response);
    }
    public function postOrder(REQUEST $request){
        // id_match`, `id_child_field`, `id_user`, `time_start`, `time_end`, `description`, `status`
        $validator = Validator::make($request->all(), [
            'id_child_field' => 'required|max:255',
            'time_start' => 'required',
            'time_end' => 'required',
            'id_match' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
        $id_match=$request->id_match;
        $id_child_field=$request->id_child_field;
        $time_start= $request->time_start;
        $time_end= $request->time_end;
        $status=$request->status;
        $description=$request->description;
        try {
            $_new=new Order();
            $_new->id_match=$id_match;
            $_new->id_child_field=$id_child_field;
            $_new->time_start= $time_start;
            $_new->time_end= $time_end;
            $_new->status=$status;
            $_new->description=$description;
            $_new->id_user=auth()->user()->id;
       
            $_new->save();
            $message="Taọ sân thành công !"; 
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Taọ sân thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }
    }
    }
    public function putOrder(REQUEST $request, $id){
        // `id_field`, `name_field`, `type`, `status`, `description`, `email_Order`, `phone_numbers`, `status`, `quantities_Order`
        $id_field=$request->id_field;
        $name_field=$request->name_field;
        $type= $request->type;
        $status=$request->status;
        $description=$request->description;
     
        try {
            $response =  Order::where('id',$id)->get();
            $_new= $response[0];
            $_new->id_field=$id_field;
            $_new->name_field=$name_field;
            $_new->type= $type;
            $_new->status=$status;
            $_new->description=$description;
            $_new->save();
            $message="Sửa sân thành công !";
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Sửa sân thất bại !";
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
