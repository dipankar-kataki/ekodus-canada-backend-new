<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function allBlog(){
        $blogs = Blog::orderBy('created_at', 'DESC')->get();
        return view('content.blog.all-blogs')->with(['blogs' => $blogs]);
      
    }

    public function viewBlogDetails($id){

        $blog_id = decrypt($id);

        $blog_details = Blog::where('id', $blog_id)->first();

        return view('content.blog.view-blog')->with(['blog_details' => $blog_details]);
    }

    public function newBlogPage(){
        return view('content.blog.add-new-blog');
    }

    public function createBlog(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'blogImage' => 'required|image|mimes:jpg,png,jpeg|max:1048',
            'blogContent' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Oops! '.$validator->errors()->first(), 'status' => 0]);
        }else{
            try{
                $imageName = null;
                if ($request->hasFile('blogImage')) {
                    $image = time() . '.' . $request->blogImage->extension();
                    $request->blogImage->move(public_path('Blog/Image/'), $image);
                    $imageName = 'Blog/Image/' . $image;
                }

                Blog::create([
                    'title' => $request->title,
                    'content' => $request->blogContent,
                    'image' => $imageName
                ]);

                return response()->json(['message' => 'Great! Blog Created Successfully', 'status' => 1]);
            }catch(\Exception $e){
                return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
            }
        }
    }

    public function editBlogDetailsPage($id){
        $blog_id = decrypt($id);

        $blog_details = Blog::where('id', $blog_id)->first();

        return view('content.blog.edit-blog')->with(['blog_details' => $blog_details]);
    }

    public function editBlog(Request $request){
        try{
            $blog_id = decrypt($request->id);

            $blog_details = Blog::where('id', $blog_id)->first();

            $imageName = null;
            if ($request->hasFile('blogImage')) {
                $image = time() . '.' . $request->blogImage->extension();
                $request->blogImage->move(public_path('Blog/Image/'), $image);
                $imageName = 'Blog/Image/' . $image;
            }else{
                $imageName = $blog_details->image;
            }

            Blog::where('id', $blog_id)->update([
                'title' => $request->title ?? $blog_details->title,
                'content' => $request->blogContent ?? $blog_details->content,
                'image' => $imageName,
                'status' => $request->status == 1 ? true : false
            ]);

            return response()->json(['message' => 'Great! Blog Updated Successfully', 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.'.$e, 'status' => 0]);
        }
    }

    public function changeStatusBlog(Request $request){
        try{
            $id = decrypt($request->id);

            Blog::where('id', $id)->update([
                'status' => $request->status
            ]);

            return response()->json(['message' => 'Great! Status Updated Successfully', 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0 ]);
        }
    }
}
