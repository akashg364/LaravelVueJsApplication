<?php

namespace App\Http\Controllers;
use App\Models\Users;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    protected $limit = 10;

    public function getRecord($id){
        $result = Users::find($id);
        if(!$result){
            return response()->json([
                'status' => 'error',
                'httpCode' => 404,
                'message' => 'user not found for requested Id',
                'data'   => [],
            ]);
        }
        return response()->json([
            'status' => 'success',
            'httpCode' => 200,
            'data'   => $result
        ]);
    }

    public function create(Request $request){
        $rules=array(
            'name' => 'required',
            'email' => 'required|email|unique:users'
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'httpCode' => 200,
                'message' => 'Request data is not valid!',
                'data'   => [],
                'errors' => $validator->errors()
            ]);
        } 

        $validator=Validator::make($request->all(),$rules);
        $reqData = new Users();
        $reqData->name = $request->input('name');
        $reqData->email = $request->input('email');
        $reqData->status = 1;
        $reqData->save();
        $userData = Users::find($reqData->id);
        return response()->json([
            'status' => 'success',
            'httpCode' => 200,
            'message' => 'record has been created successfully!',
            'data'   => $userData,
        ]);
    }
}
