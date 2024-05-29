<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    //
    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('username', 'firstname', 'lastname', 'phonenumber', 'email', 'password');
        $validator = Validator::make($data, [
            'username' => 'required|string|unique:users',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phonenumber' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], Response::HTTP_BAD_GATEWAY);
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

        //Create token
        try {
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], Response::HTTP_NOT_FOUND);
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
        ], Response::HTTP_OK);
    }
    public function get_user(Request $request)
    {
        //     $this->validate($request, [
        //         'token' => 'required'
        //     ]);

        // $user = JWTAuth::authenticate($request->token);
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json(['user' => $user]);
    }

    public function protected()
    {
        return response()->json(['test' => 'teset'], Response::HTTP_OK);
    }
    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh(true, true);
            return response()->json(['status' => 'Token refreshed', 'token' => $newToken], Response::HTTP_OK);
        } catch (Exception $e) {
            if ($e instanceof TokenExpiredException) {
                return response()->json(['status' => 'Refresh Token is Expired'], Response::HTTP_UNAUTHORIZED);
            } else {
                return response()->json(['status' => $e->getMessage()]);
            }
        }
    }
}
