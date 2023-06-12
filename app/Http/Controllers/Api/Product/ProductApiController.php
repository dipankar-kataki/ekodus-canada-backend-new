<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function getAllProducts(){
        try{
            $all_products = Product::where('status', 1)->orderBy('created_at', 'DESC')->get();
            return response()->json(['message' => 'Great! Details Fetched Successfully','products' => $all_products, 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
        }
    }

    public function productDetails(){
        if(!isset($_GET['product_id'])){
            return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
        }else{
            if($_GET['product_id'] == 0){
                return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
            }else{
                try{
                    $get_product_details = Product::where('id', $_GET['product_id'])->where('status', 1)->first();
                    return response()->json(['message' => 'Great! Details Fetched Successfully', 'product_details' => $get_product_details, 'status' => 1]);
                }catch(\Exception $e){
                    return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
                }
            }
        }
    }
}
