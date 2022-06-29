<?php

namespace App\Http\Controllers;
use App\Models\Websites;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class WebsiteController extends Controller
{
    protected $limit = 10;

    public function getAllRecords(){ //print_r($_GET['userId']);exit;
        $cond = "";
        if(isset($_GET['userId'])){
            $cond .= " AND userId=".$_GET['userId'];
        }else{
            $cond = " AND userId= -1 ";
        }
        $webSubscribers = DB::select("SELECT A.*, ( select IF(count(*)>0,1,0) from subscribers B where B.websiteId = A.id  ".$cond.") as isAlreadySubscribed FROM `websites` A");
        $webSubscribers = json_decode(json_encode($webSubscribers), true);
        
        //$websites = Websites::paginate($this->limit);
        return response()->json([
            'status' => 'success',
            'httpCode' => 200,
            'data'   => $webSubscribers,
            'pagination' => []
        ]);
    }
    public function getRecord($id){
        $website = Websites::find($id);
        if(!$website){
            return response()->json([
                'status' => 'error',
                'httpCode' => 404,
                'errorMsg' => 'website not found for requested Id',
                'data'   => [],
            ]);
        }
        return response()->json([
            'status' => 'success',
            'httpCode' => 200,
            'data'   => Websites::find($id)
        ]);
    }

    public function create(Request $request){
        
        $rules=array(
            'name' => 'required',
            'description' => 'required'
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
        $reqData = new Websites();
        $reqData->name = $request->input('name');
        $reqData->description = $request->input('description');
        $reqData->status = 1;
        $reqData->save();

        return response()->json([
            'status' => 'success',
            'httpCode' => 200,
            'message' => 'record has been created successfully!',
            'data'   => [],
        ]);
    }
}
