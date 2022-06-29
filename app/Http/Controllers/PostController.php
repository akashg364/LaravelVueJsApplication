<?php

namespace App\Http\Controllers;
use App\Models\Posts;
use App\Models\Subscribers;
use App\Models\Users;
use Illuminate\Http\Request;

use Event;
use App\Events\SendMail;

use Illuminate\Support\Facades\DB;
use Validator;

class PostController extends Controller
{
    protected $limit = 10;

    public function getRecord($id){
        $result = Posts::find($id);
        if(!$result){
            return response()->json([
                'status' => 'error',
                'httpCode' => 404,
                'message' => 'record not found for requested Id',
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
            'websiteId' => 'required',
            'userId' => 'required',
            'title' => 'required|unique:posts',
            'description' => 'required|unique:posts'
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
        
        $reqData = new Posts();
        $reqData->userId = $request->input('userId');
        $reqData->websiteId = $request->input('websiteId');
        $reqData->title = $request->input('title');
        $reqData->description = $request->input('description');
        $reqData->status = 1;
        $reqData->save();

        // trigger email to all subscribers        
        $webSubscribers = DB::table("Subscribers AS A") 
        ->leftJoin("websites AS C", "A.websiteId","=","C.id")
        ->leftJoin("users AS B",function($join){
            $join->on("A.userId","=","B.id");
        })->select('B.email', 'C.name as webName')->where('A.websiteId', $request->input('websiteId'))->get();
        
        foreach ($webSubscribers as $key => $value) {
            $emailData = array(
                'email'     =>  $value->email,
                'webName'   =>  $value->webName,
                'title'     =>  $request->input('title'),
                'description' =>    $request->input('description')
            );

            Event::dispatch(new SendMail($emailData));
        }
        
        return response()->json([
            'status' => 'success',
            'httpCode' => 200,
            'message' => 'record has been created successfully!',
            'data'   => [],
        ]);

        
    }
}
