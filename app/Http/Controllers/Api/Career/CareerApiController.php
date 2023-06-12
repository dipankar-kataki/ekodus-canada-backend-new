<?php

namespace App\Http\Controllers\Api\Career;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerApiController extends Controller
{
    public function getCareer(){
        try{
            $get_career = Career::where('status', 1)->get();
            return response()->json(['message' => 'Careers Fetched Successfully', 'careers' => $get_career, 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
        }
    }

    public function getCareerDetails(){
        if(!isset($_GET['career_id'])){
            return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
        }else{
            if($_GET['career_id'] == 0){
                return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
            }else{
                try{
                    $get_career_details = Career::where('id', $_GET['career_id'])->where('status', 1)->first();
                    return response()->json(['message' => 'Great! Details Fetched Successfully', 'career_details' => $get_career_details, 'status' => 1]);
                }catch(\Exception $e){
                    return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
                }
            }
        }
    }
}
