<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function getAllServices(){
        try{
            $all_services = Service::orderBy('created_at', 'DESC')->get();
            return view('content.services.index')->with(['services' => $all_services]);
        }catch(\Exception $e){
            echo 'Oops! Something Went Wrong';
        }
    }


    public function createService(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'serviceImage' => 'required|image|mimes:jpg,png,jpeg|max:1048',
            'shortDescription' => 'required',
            'longDescription' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Oops! '.$validator->errors()->first(), 'status' => 0]);
        }else{
            try{

                $imageName = null;
                if ($request->hasFile('serviceImage')) {
                    $image = time() . '.' . $request->serviceImage->extension();
                    $request->serviceImage->move(public_path('Service/Image/'), $image);
                    $imageName = 'Service/Image/' . $image;
                }


                Service::create([
                    'title' => $request->title,
                    'image' => $imageName,
                    'short_description' => $request->shortDescription,
                    'full_description' => $request->longDescription
                ]);
                return response()->json(['message' => 'Great! Service Created Successfully', 'status' => 1]);
            }catch(\Exception $e){
                return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
            }
        }
        
    }


    public function serviceDetails($id){
        try{
            $id = decrypt($id);

            $get_details = Service::where('id', $id)->first();
            return view('content.services.details')->with(['service_details' => $get_details]);
        }catch(\Exception $e){
            echo 'Oops! Something Went Wrong';
        }
    }

    public function editService(Request $request, $id){

        try{
            $service_id = decrypt($id);
            $get_details = Service::where('id', $service_id)->first();
            return view('content.services.edit')->with(['service_details' => $get_details]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
        }
        
    }

    public function saveEditService(Request $request){
        try{
            $service_id = decrypt($request->id);

            $service_details = Service::where('id', $service_id)->first();

            $imageName = null;
            if ($request->hasFile('serviceImage')) {
                $image = time() . '.' . $request->serviceImage->extension();
                $request->serviceImage->move(public_path('Service/Image/'), $image);
                $imageName = 'Service/Image/' . $image;
            }else{
                $imageName = $service_details->image;
            }

            Service::where('id', $service_id)->update([
                'title' => $request->title ?? $service_details->title,
                'short_description' => $request->shortDescription ?? $service_details->short_description,
                'full_description' => $request->longDescription ?? $service_details->full_description,
                'image' => $imageName,
                'status' => $request->status == 1 ? true : false
            ]);

            return response()->json(['message' => 'Great! Service Edited Successfully.', 'status' => 1]);
            
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
        }
    }

    public function changeStatus(Request $request){
        try{
            $id = decrypt($request->id);

            Service::where('id', $id)->update([
                'status' => $request->status
            ]);

            return response()->json(['message' => 'Great! Status Updated Successfully', 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0 ]);
        }
    }
}
