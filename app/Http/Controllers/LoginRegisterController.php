<?php

namespace App\Http\Controllers;

use App\Models\otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{
    public function Register(Request $request)
    {
        //Validation
        $validation = validator::make($request->all(), [

            'mobile_no' => 'required|max:11|unique:users',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        //Create New User in users table
        $user = User::create([
            'mobile_no' => $request->mobile_no
        ]);
        $token = $user->createToken('personal_access_tokens')->plainTextToken;
        $msg = ['registered successfully', 'user' => $user, 'token' => $token];
        return response()->json($msg, 400);
    }
    //Login 
    public function login(Request $request)
    {
        //validation Inputs
        $rules = [
            'mobile_no' => 'required'
        ];
        $request->validate($rules);
        //find User in users Table
        $user = User::where('mobile_no', $request->mobile_no)->first();
        if ($user /* Hash::check($request->password,$user->password) */) {
            $token = $user->createToken('personal_access_tokens')->plainTextToken;
            $response = ['user' => $user, 'token' => $token];
            return response()->json($response, 200);
        }
        $response = ['email or password not correct'];
        return response()->json($response, 400);
    }
}
