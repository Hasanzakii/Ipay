<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //List Of Users
    public function List()
    {
        $product = Brand::find(1)->products;

        dd($product);
    }
    //register
    public function createUser(Request $request)
    {
        try {
            $validateUser = validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'mobile_no' => 'required', 'number', 'max:10',
                'password' => 'required'
            ]);

            /* ValidateSolution2
              -- We can use $request to validate 
              $request->validate([
                'title' -> 'required',
                'user' -> 'required'''
            
              ]); */

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            // $NewUser = new User;
            // $NewUser->name = $request->name;
            // $NewUser->email = $request->email;
            // $NewUser->password = $request->password;
            // $result = $NewUser->save();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function Login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        return $token;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
