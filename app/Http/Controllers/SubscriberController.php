<?php

namespace App\Http\Controllers;
use App\Models\Subscribers;
use App\Models\Websites;
use Illuminate\Http\Request;
use Validator;
class SubscriberController extends Controller
{
    protected $limit = 10;

    public function getRecord($id){
        $result = Subscribers::find($id);
        if(!$result){
            return response()->json([
                'status' => 'error',
                'httpCode' => 404,
                'message' => 'subscriber not found for requested Id',
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
            'userId' => 'required'
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
        $isAlreadySubscribed = Subscribers::where(['websiteId' => $request->input('websiteId'), 'userId' => $request->input('userId')])->count();
     
        if ( $isAlreadySubscribed > 0) {
            return response()->json([
                'status' => 'error',
                'httpCode' => 200,
                'message' => 'You are already subscribed to this website!',
                'data'   => [],
            ]);
        } else {
            $reqData = new Subscribers();
            $reqData->userId = $request->input('userId');
            $reqData->websiteId = $request->input('websiteId');
            $reqData->status = 1;
            $reqData->save();
            Websites::where('id',$request->input('websiteId'))->increment('totalSubscribers', 1);
                
            return response()->json([
                'status' => 'success',
                'httpCode' => 200,
                'message' => 'record has been created successfully!',
                'data'   => [],
            ]);
            
        }
    }
}
