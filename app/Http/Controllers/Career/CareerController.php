<?php

namespace App\Http\Controllers\Career;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CareerController extends Controller
{
    public function viewAllOpenings(){
        try{
            $active_openings = Career::where('status', 1)->orderBy('created_at', 'DESC')->get();
            $deactive_openings = Career::where('status', 0)->orderBy('created_at', 'DESC')->get();

            return view('content.career.index')->with(['active_openings' => $active_openings, 'deactive_openings' => $deactive_openings]);
        }catch(\Exception $e){
            echo 'Oops Something Wnet Wrong';
        }
        
    }


    public function createOpening(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'location' => 'required',
            'experience' => 'required|numeric|gt:0',
            'shift' => 'required',
            'jobDescription' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Oops! '.$validator->errors()->first(), 'status' => 0]);
        }else{
            try{

                Career::create([
                    'job_title' => $request->title,
                    'job_description' => $request->jobDescription,
                    'job_location' => $request->location,
                    'job_experience' => $request->experience,
                    'job_shift' => $request->shift
                ]);

                return response()->json(['message' => 'Great! Opening Created Successfully', 'status' => 1]);
            }catch(\Exception $e){
                return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
            }
        }
    }

    public function viewOpening($id){
        try{
            $career_id = decrypt($id);

            $career_details = Career::where('id', $career_id)->first();
            return view('content.career.details')->with(['career_details' => $career_details]);
        }catch(\Exception $e){
            echo 'Oops! Something Went Wrong';
        }
    }

    public function editOpening(Request $request){
        try{
            
            $id = decrypt($request->id);

            $career_details = Career::where('id', $id)->first();

            Career::where('id', $id)->update([
                'job_title' => $request->title ?? $career_details->job_title,
                'job_description' => $request->jobDescription ??  $career_details->job_description,
                'job_location' => $request->location ??  $career_details->job_location,
                'job_experience' => $request->experience ??  $career_details->job_experience,
                'job_shift' => $request->shift ?? $career_details->job_shift,
                'status' => $request->status ??  $career_details->status
            ]);

            return response()->json(['message' => 'Great! Job Edited Successfully', 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong', 'status' => 0]);
        }
    }


    public function changeStatus(Request $request){
        try{
            $id = decrypt($request->id);

            Career::where('id', $id)->update([
                'status' => $request->status
            ]);

            return response()->json(['message' => 'Great! Status Updated Successfully', 'status' => 1]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong'. $e, 'status' => 0 ]);
        }
    }
}
