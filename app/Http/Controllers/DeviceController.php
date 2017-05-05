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

    public function connect(Request $request){
        $serial = str_random(40);
        //Delete the current device serial
        $sql = "DELETE FROM device WHERE 1";
        DB::delete($sql);
        //Add new serial to the database
        $sql = "INSERT INTO device (serial) VALUES (?)";
        DB::insert($sql,[$serial]);
        $response = new JsonResponse();
        return $response->setData(['serial'=>$serial,'status'=>$request['status']]);
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
            $sql = "DELETE FROM buffer WHERE 1";
            DB::delete($sql);
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
