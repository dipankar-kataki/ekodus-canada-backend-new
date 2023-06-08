<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getAllProducts(){
        try{
            $all_products = Product::orderBy('created_at', 'DESC')->get();
            return view('content.product.index')->with(['products' => $all_products]);
        }catch(\Exception $e){
            echo 'Oops! Something Went Wrong';
        }
    }

    public function createProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'productImage' => 'required|image|mimes:jpg,png,jpeg|max:1048',
            'shortDescription' => 'required',
            'longDescription' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Oops! '.$validator->errors()->first(), 'status' => 0]);
        }else{
            try{

                $imageName = null;
                if ($request->hasFile('productImage')) {
                    $image = time() . '.' . $request->productImage->extension();
                    $request->productImage->move(public_path('Product/Image/'), $image);
                    $imageName = 'Product/Image/' . $image;
                }


                Product::create([
                    'title' => $request->title,
                    'image' => $imageName,
                    'short_description' => $request->shortDescription,
                    'full_description' => $request->longDescription
                ]);
                return response()->json(['message' => 'Great! Product Created Successfully', 'status' => 1]);
            }catch(\Exception $e){
                return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
            }
        }
    }

    public function productDetails($id){
        try{
            $id = decrypt($id);

            $get_details = Product::where('id', $id)->first();
            return view('content.product.details')->with(['product_details' => $get_details]);
        }catch(\Exception $e){
            echo 'Oops! Something Went Wrong';
        }
    }

    public function editProduct($id){
        try{
            $product_id = decrypt($id);
            $get_details = Product::where('id', $product_id)->first();
            return view('content.product.edit')->with(['product_details' => $get_details]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
        }
    }

    public function saveEditProduct(Request $request){
        try{
            $product_id = decrypt($request->id);

            $product_details = Product::where('id', $product_id)->first();

            $imageName = null;
            if ($request->hasFile('productImage')) {
                $image = time() . '.' . $request->productImage->extension();
                $request->productImage->move(public_path('Product/Image/'), $image);
                $imageName = 'Product/Image/' . $image;
            }else{
                $imageName = $product_details->image;
            }

            Product::where('id', $product_id)->update([
                'title' => $request->title ?? $product_details->title,
                'short_description' => $request->shortDescription ?? $product_details->short_description,
                'full_description' => $request->longDescription ?? $product_details->full_description,
                'image' => $imageName,
                'status' => $request->status == 1 ? true : false
            ]);

            return response()->json(['message' => 'Great! Product Edited Successfully.', 'status' => 1]);
            
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
        }
    }

    public function changeStatus(Request $request){
        try{
            $id = decrypt($request->id);

            Product::where('id', $id)->update([
                'status' => $request->status
            ]);

            return response()->json(['message' => 'Great! Status Updated Successfully', 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0 ]);
        }
    }
}
