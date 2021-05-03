<?php

namespace App\Http\Controllers\Booking;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
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
    public function checkTimePlayAvailable(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'dateTime'=> 'required',
            'id_child_field' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
        $date = Carbon::parse($request->dateTime);
        $response =  Order::whereDate('time_start','=', $date->format('Y-m-d'))
        ->whereTime('time_start','<=', $date->format('H:i:s'))
        ->whereTime('time_end','>', $date->format('H:i:s'))
        ->whereTime('id_child_field', $request->id_child_field)
        ->get();
        //['date'=>$date->format('Y-m-d'),'time'=>$date->format('H:i:s') ]
        return  response()->json($response);
        }
    }
    public function getOrder($id)
    {
        $response =  Order::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getOrderByIdUser($id)
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
        //(`id_match`, `id_child_field`, `id_user`, `time_start`, `time_end`, `description`, `status`, `method_pay`)
      
        $validator = Validator::make($request->all(), [
            'id_child_field' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'method_pay' => 'required',
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }else{

            try {
                $_new=new Order();
                $_new->id_match=$request->id_match;
                $_new->id_child_field=$request->id_child_field;
                $_new->id_user=auth()->user()->id;
                $_new->time_start=$request->time_start;
                $_new->time_end=$request->time_end;
                $_new->description=$request->description;
                $_new->method_pay=$request->method_pay;
                $_new->status = 0;
                $_new->save();
                $message="Taọ sân thành công !"; 
                $response = array('message'=>$message,'error'=>null , 'orderInfo' => Order::latest()->first());
                return  response()->json($response);
            } catch (Exception $e) {
                $message="Taọ sân thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
            }
         }
    }
    public function putOrder(REQUEST $request, $id){
       //(`id_match`, `id_child_field`, `id_user`, `time_start`, `time_end`, `description`, `status`, `method_pay`)
      
       $validator = Validator::make($request->all(), [
        'id_child_field' => 'required',
        'time_start' => 'required',
        'time_end' => 'required',
        'method_pay' => 'required',
    ]);
     if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
     }else{

        try {
            $_new=Order::where('id', $id)->get();
            $_new= $_new[0];
            $_new->id_match=$request->id_match;
            $_new->id_child_field=$request->id_child_field;
            $_new->id_user=auth()->user()->id;
            $_new->time_start=$request->time_start;
            $_new->time_end=$request->time_end;
            $_new->description=$request->description;
            $_new->method_pay=$request->method_pay;
            $_new->status = $request->status;
            $_new->save();
            $message="Sua sân thành công !"; 
            $response = array('message'=>$message,'error'=>null);
            return  response()->json($response);
        } catch (Exception $e) {
            $message="Sua sân thất bại !";
            $response = array('message'=>$message,'error'=>$e);
            return  response()->json($response);
        }
     }
    }
    public function putOrderMatch(REQUEST $request,$id){
        $validator = Validator::make($request->all(), [
            'id_match' => 'required',
        ]);
      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }else{
         try {
             $_new=Order::where('id', $id)->get();
             $_new= $_new[0];
             $_new->id_match = $request->id_match;
             $_new->save();
             $message="Sua sân thành công !"; 
             $response = array('message'=>$message,'error'=>null);
             return  response()->json($response);
         } catch (Exception $e) {
             $message="Sua sân thất bại !";
             $response = array('message'=>$message,'error'=>$e);
             return  response()->json($response);
         }
      }
     }
    public function putOrderStatus(REQUEST $request,$id){
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }else{
         try {
             $_new=Order::where('id', $id)->get();
             $_new= $_new[0];
             $_new->status = $request->status;
             $_new->save();
             $message="Sua sân thành công !"; 
             $response = array('message'=>$message,'error'=>null);
             return  response()->json($response);
         } catch (Exception $e) {
             $message="Sua sân thất bại !";
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
