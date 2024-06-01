<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
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

        //mengembalikan respon gagal jika validator gagal
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->getMessageBag(), 'code' => Response::HTTP_BAD_REQUEST]);
        }
        //Request is valid, create new user
        User::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phonenumber' => $request->phonenumber,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //Data User terbuat, kembalikan success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'code' => Response::HTTP_OK
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        Log::info("email : " . $request->email);
        Log::info("password : " . $request->password);
        //Create token
        try {
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                Log::info("Login credentials are invalid.");
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                    'code' => Response::HTTP_NOT_FOUND
                ]);
            }
        } catch (JWTException $e) {
            // return $credentials;
            Log::info("error login " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
                'code' => 500
            ]);
        }

        //Token created, return with success response and jwt token
        Log::info("Token : $token");
        $user = JWTAuth::authenticate($token);
        return response()->json([
            'success' => true,
            'token' => $token,
            'username' => $user->username,
            'code' => Response::HTTP_OK
        ]);
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
            return response()->json(['status' => 'Token refreshed', 'token' => $newToken, 'code' => Response::HTTP_OK]);
        } catch (Exception $e) {
            if ($e instanceof TokenExpiredException) {
                return response()->json(['status' => 'Refresh Token is Expired', 'code' => Response::HTTP_UNAUTHORIZED]);
            } else {
                return response()->json(['status' => $e->getMessage(), 'code' => Response::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }
}
