<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{

    public function signUp(Request $request)
    {

        $ifexist = DB::table('users')->where('email',$request->email)->first();
        if(empty($ifexist))
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>Hash::make($request->password)
            ]);
            // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $token = $user->createToken('bagisto')->accessToken;
            // $token = $user->createToken("API TOKEN")->plainTextToken;
            $accessToken = $token;
            return response()->json([
                'status' => true,
                'message' => 'Signed in successfully',
                'token' => $accessToken,
                'data' => $user
            ], 200);
           
        }
        
        return response()->json([
            'status' => false,
            'message' => 'User Already Exist',
        ],422);

    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email',
            "password" => [
                "required",
                "min:8"
            ],
        ]);

        if ($validation->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first()
            ], 401);
        }
        $existUser = User::where('email', $request->email)->first();

        if (empty($existUser)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Email or Password'
            ], 401);
        }

        if (!Hash::check($request->password, $existUser->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect Password!',
            ], 200);
        } else {
            // $token = $existUser->createToken('Laravel Password Grant Client')->plainTextToken;
            $token = $existUser->createToken('bagisto');
            // $user_token['token'] = $existUser->createToken('appToken');
            $accessToken = $token->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'Signed in successfully',
                'token' => $accessToken,
                'data' => $existUser
            ], 200);
        }
    }

    public function sendOtp(Request $request)
    {
        $verify_email=User::where('email',$request->email)->first();
        if($verify_email)
        {
                //send mail
        }
        else
        {
            return response()->json(['status'=>false,'message'=>'user not found'],422);
        }
    }

    public function forgetpassword(Request $request)
    {
        
    }
}
