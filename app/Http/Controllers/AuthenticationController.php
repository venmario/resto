<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    //
    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('username', 'firstname', 'lastname', 'phonenumber', 'email', 'password');
        $validator = Validator::make($data, [
            'username' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phonenumber' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }
        //Request is valid, create new user
        $user = User::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phonenumber' => $request->phonenumber,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        //Request is validated
        //Crean token
        // $credentials = ['email'=>'abc@gmail.com','password'=>'12345'];
        try {
            $token = JWTAuth::attempt($credentials);
            // dd($token);
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            // return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        $user = JWTAuth::authenticate($request->token);
        return response()->json(['user' => $user]);
    }

    public function protected()
    {
        return response()->json(['test' => 'teset'], Response::HTTP_OK);
    }
}
