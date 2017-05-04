<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function inputData(Request $request){
        $response = new JsonResponse();
        if(!isset($request['status'])){
            $response->setData(['error'=>'true', 'field'=>'status', 'details'=>'Required parameter is missing']);
            return $response;
        }else{
            //---------------------------------------
            //Start the sync process

            $status = $request['status'];
            $sql = "INSERT INTO buffer (array) VALUES (?)";
            DB::insert($sql,[$status]);

            //---------------------------------------
            return $response->setData([
                'error'=>'false',
                'details'=>'inputData post request successful'
            ]);
        }
    }
}
