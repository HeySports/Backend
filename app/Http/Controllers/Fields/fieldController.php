<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use Validator;
class fieldController extends Controller
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
    public function putFieldRating(REQUEST $request, $id){
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }else{
             try{
                $response =  Field::where('id',$id)->get();
                $_new= $response[0];
                $_new->rating = ($request->rating + $_new->rating*$_new->rating_number)/($_new->rating_number+1);
                $_new->rating_number = $_new->rating_number+1;
                $_new->save();
                $message="Rating thành công !";
                $response = array('message'=>$message,'error'=>null);
                return  response()->json($response);
             }catch(Exception $e){
                $message="Rating thất bại !";
                $response = array('message'=>$message,'error'=>$e);
                return  response()->json($response);
             }
            
         }

    }

    public function getDetailField($id)
    {
        $response =  Field::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getListField()
    {
        return Field::all();
    }
    public function deleteField($id)
    {
        $field = Field::findOrFail($id);
        if($field)
         {  $field->delete(); }
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
    public function postField(REQUEST $request){
        // `id_owner`, `name`, `rating`, `list_image`, `address`, `email_field`, `phone_numbers`, `status`, `quantities_field`
        $id_owner=$request->id_owner;
        $name=$request->name;
        $rating= $request->rating;
        $list_image=$request->list_image;
        $address=$request->address;
        $email_field=$request->email_field;
        $phone_numbers=$request->phone_numbers;
        $status=$request->status;
        $quantities_field=$request->quantities_field;
        try {
            $_new=new Field();
            $_new->id_owner=$id_owner;
            $_new->name=$name;
            $_new->rating= $rating;
            $_new->list_image=$list_image;
            $_new->address=$address;
            $_new->email_field=$email_field;
            $_new->phone_numbers=$phone_numbers;
            $_new->status=$status;
            $_new->credit=$credit;
            $_new->quantities_field=$quantities_field;
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
    public function putField(REQUEST $request, $id){
        // `id_owner`, `name`, `rating`, `list_image`, `address`, `email_field`, `phone_numbers`, `status`, `quantities_field`
        $id_owner=$request->id_owner;
        $name=$request->name;
        $rating= $request->rating;
        $list_image=$request->list_image;
        $address=$request->address;
        $email_field=$request->email_field;
        $phone_numbers=$request->phone_numbers;
        $status=$request->status;
        $quantities_field=$request->quantities_field;
        try {
            $response =  Field::where('id',$id)->get();
            $_new= $response[0];
            $_new->id_owner=$id_owner;
            $_new->name=$name;
            $_new->rating= $rating;
            $_new->list_image=$list_image;
            $_new->address=$address;
            $_new->email_field=$email_field;
            $_new->phone_numbers=$phone_numbers;
            $_new->status=$status;
            $_new->credit=$credit;
            $_new->quantities_field=$quantities_field;
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
