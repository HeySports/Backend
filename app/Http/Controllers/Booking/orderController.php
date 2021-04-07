<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
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
        // `id_field`, `name_field`, `type`, `status`, `description`
        $id_field=$request->id_field;
        $name_field=$request->name_field;
        $type= $request->type;
        $status=$request->status;
        $description=$request->description;
    
        try {
            $_new=new Order();
            $_new->id_field=$id_field;
            $_new->name_field=$name_field;
            $_new->type= $type;
            $_new->status=$status;
            $_new->description=$description;
       
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
