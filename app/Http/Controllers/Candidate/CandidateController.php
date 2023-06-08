<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function allCandidates(){
        try{
            $list_of_candidates = Candidate::orderBy('created_at', 'DESC')->get();
            return view('content.candidate.index')->with(['list_of_candidates' => $list_of_candidates]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
            'resume' => "required|mimes:pdf,docx|max:5000"
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Oops! '.$validator->errors()->first(), 'status' => 0]);
        }else{
            try{
                $resumeName = null;
                if ($request->hasFile('resume')) {
                    $resume = time() . '.' . $request->resume->extension();
                    $request->resume->move(public_path('Candidate/Resume/'), $resume);
                    $resumeName = 'Candidate/Resume/' . $resume;
                }

                $check_if_phone_exists = Candidate::where('phone', $request->country_code.$request->phone)->exists();
                $check_if_email_exists = Candidate::where('email', $request->email)->exists();

                if($check_if_email_exists){
                    return response()->json(['message' => 'Oops! Email Id Already Exists.', 'status' => 0]);
                }else if($check_if_phone_exists){
                    return response()->json(['message' => 'Oops! Phone Number Already Exists.', 'status' => 0]);
                }else{
                    Candidate::create([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'gender' => $request->gender,
                        'phone' => $request->country_code.$request->phone,
                        'resume' => $resumeName
                    ]);

                    return response()->json(['message' => 'Great! Details Submitted Successfully.', 'status' => 1]);
                }
            }catch(\Exception $e){
                return response()->json(['message' => 'Oops! Something Went Wrong.', 'status' => 0]);
            }
        }
    }
}
