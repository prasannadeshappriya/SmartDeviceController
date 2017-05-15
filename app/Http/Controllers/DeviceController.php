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

    public function storeData(Request $request){
        $sql = "UPDATE buffer SET array=?";
        DB::insert($sql,[$request['data']]);

    }

    public function readData(Request $request){
        $serial = $request['serial'];
        $response = new JsonResponse();
        $result_arr = [];
        $result = DB::select("SELECT serial FROM device where 1");
        foreach ($result as $row){
            $result_arr[] = (array) $row;
        }
        if(empty($result_arr)){
            return $response->setData([
                'error' => 'No Devices Are Connected!'
            ]);
        }else{
            if($serial===$result_arr[0]['serial']){
                $data_arr = [];
                $data_result = DB::select("SELECT array FROM buffer where 1");
                foreach ($data_result as $row){
                    $data_arr[] = (array) $row;
                }
                return $response->setData([
                    'data' => $data_arr[0]['array']
                ]);
            }else{
                return $response->setData([
                    'error' => 'Invalid Serial Number'
                ]);
            }
        }
    }

    public function disconnect(Request $request){
        //Delete the current device serial
        $sql = "DELETE FROM device WHERE 1";
        DB::delete($sql);
        $response = new JsonResponse();
        return $response->setData(['response'=>$request['status']]);
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
