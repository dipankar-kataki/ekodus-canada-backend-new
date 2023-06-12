<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function getAllService(){
        try{
            $all_services = Service::where('status', 1)->orderBy('created_at', 'DESC')->get();
            return response()->json(['message' => 'Great! Details Fetched Successfully','services' => $all_services, 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
        }
    }

    public function serviceDetails(){
        if(!isset($_GET['service_id'])){
            return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
        }else{
            if($_GET['service_id'] == 0){
                return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
            }else{
                try{
                    $get_service_details = Service::where('id', $_GET['service_id'])->where('status', 1)->first();
                    return response()->json(['message' => 'Great! Details Fetched Successfully', 'service_details' => $get_service_details, 'status' => 1]);
                }catch(\Exception $e){
                    return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
                }
            }
        }
    }
}
