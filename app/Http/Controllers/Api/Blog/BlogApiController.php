<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    public function getBlogs(){
        try{
            $get_blogs = Blog::orderBy('created_at', 'DESC')->where('status', 1)->get();
            return response()->json(['message' => 'Details Fetched Successfully', 'blogs' => $get_blogs, 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
        }
    }

    public function details(){
        if(!isset($_GET['blog_id'])){
            return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
        }else{
            if($_GET['blog_id'] == 0){
                return response()->json(['message' => 'Oops! Invalid Parameters Passed.', 'status' => 0]);
            }else{
                try{
                    $get_blog_details = Blog::where('id', $_GET['blog_id'])->where('status', 1)->first();
                    return response()->json(['message' => 'Great! Details Fetched Successfully', 'blog_details' => $get_blog_details, 'status' => 1]);
                }catch(\Exception $e){
                    return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
                }
            }
        }
    }
}
