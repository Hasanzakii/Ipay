<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class AuthOtpController extends Controller
{

    public function generateOtp($mobile_no)
    {


        $users = User::where('mobile_no', $mobile_no)->firstOrCreate([
            'mobile_no' => $mobile_no,
        ]);
        $users->save();
        // if User doesn't exist ---> CreateUser
        // if (!$users) {
        //     $users = User::create([
        //         'mobile_no' => $mobile_no,
        //     ]);
        // }
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $users->id)->latest()->first();

        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }
        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $users->id,
            'otp' => rand(1111, 9999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    //Generate OTP
    public function generate(Request $request)
    {

        #validate Data
        $validation = Validator::make($request->all(), [

            'mobile_no' => 'required|min:11|max:11',

        ])->validate();
        #Generate An OTP
        $verificationCode = $this->generateOtp($request->mobile_no);
        $message = "Your OTP To Login is - " . $verificationCode->otp;

        #Return OTP (on screen or SMS)

        return response()->json([
            'message' => $message
        ]);
    }


    //Verify mobile_no & the otp 
    public function verify(Request $request)
    {
        //Validate Inputs
        $validation = Validator::make($request->all(), [

            'mobile_no' => 'required|exists:users|max : 11|min : 11',
            'otp' => 'required',
        ])->validate();
        $verificationCode = VerificationCode::where('otp', $request->otp)->first();
        $now = Carbon::now();
        if (!$verificationCode) {
            return ('Your OTP is not correct');
        } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            return redirect('Your OTP has been expired');
        }


        $user = User::where('mobile_no', $request->mobile_no)->first();
        return response()->json([

            'token' => $user->createToken("personal_access_tokens ")->plainTextToken

        ], 200);
    }


    //Get User Data 
    public function GetUser(Request $request)
    {
        return response()->json(Auth::user(), 200);
    }

    //Update user information in RegisterForm
    public function UpdateUser(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'City' => 'string|nullable',
                'Name' => 'string|nullable',
                'gender' => 'nullable',

            ]
        )->validate();
        //Go to register form
        $user = User::find(Auth::user()->id);
        $user->Name = $request->Name;
        $user->City = $request->City;
        $user->gender = $request->gender;
        $user->status = 1;
        $user->save();

        return response()->json($user, 200);
    }

    //This method update user status to "1" to skip the register form
    public function Skip(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->status = 1;
        $user->save();
        return response()->json([


            "status => $user->mobile_no" => $user->status,
            'message' => 'Status Updated Successfully',
        ], 200);
    }


    //Logout
    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([

            'status_code' => 200,
            'message' => 'Token deleted successfully',
        ]);
    }
}
