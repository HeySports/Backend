<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildField;
class childFieldController extends Controller
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
    public function getChildField($id)
    {
        $response =  ChildField::where('id',$id)->get();
        return  response()->json($response[0]);
    }
    public function getChildFieldsByField()
    {
        $response = ChildField::all();
        return  response()->json($response);
    }
    public function deleteChildField($id)
    {
        $ChildField = ChildField::findOrFail($id);
        if($ChildField)
         {  $ChildField->delete(); }
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
    public function postChildField(REQUEST $request){
        // `id_field`, `name_field`, `type`, `status`, `description`
        $id_field=$request->id_field;
        $name_field=$request->name_field;
        $type= $request->type;
        $status=$request->status;
        $description=$request->description;
    
        try {
            $_new=new ChildField();
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
    public function putChildField(REQUEST $request, $id){
        // `id_field`, `name_field`, `type`, `status`, `description`, `email_ChildField`, `phone_numbers`, `status`, `quantities_ChildField`
        $id_field=$request->id_field;
        $name_field=$request->name_field;
        $type= $request->type;
        $status=$request->status;
        $description=$request->description;
     
        try {
            $response =  ChildField::where('id',$id)->get();
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
