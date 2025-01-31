<?php

namespace App\Http\Controllers;

use App\Models\Fcm;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        $credentials = $request->only('username', 'password');
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

        $oldFcmToken = $request->oldFcmToken;
        $currentFcmToken = $request->currentFcmToken;
        Log::info("old fcm token : " . $oldFcmToken);
        Log::info("current fcm token : " . $currentFcmToken);


        $updatedFcmToken = false;
        DB::beginTransaction();
        try {
            $user = User::where('username', $request->username)->first();
            if ($oldFcmToken == $currentFcmToken) {
                $userFcmTokens = $user->fcm;
                $found = false;
                foreach ($userFcmTokens as $userFcmToken) {
                    if ($userFcmToken == $currentFcmToken) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    Fcm::create(['fcm_token' => $currentFcmToken, 'user_id' => $user->id]);
                    $updatedFcmToken = true;
                }
            } else {
                Fcm::find($oldFcmToken)->delete();
                Fcm::create(['fcm_token' => $currentFcmToken, 'user_id' => $user->id]);
                $updatedFcmToken = true;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("error message : " . $e->getMessage());
        }


        return response()->json([
            'success' => true,
            'token' => $token,
            'updatedFcmToken' => $updatedFcmToken,
            'code' => Response::HTTP_OK
        ]);
    }

    public function logout(Request $request)
    {
        $fcmToken = $request->fcmToken;
        try {
            Fcm::find($fcmToken)->delete();
            return response()->json(['isSuccess' => true]);
        } catch (Exception $e) {
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage()]);
        }
    }
    public function get_user(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'success' => true,
                'successMessage' => 'Success retrieve user data',
                'errorMessage' => null,
                'user' => User::find($user->id),
                'code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => true,
                'successMessage' => null,
                'errorMessage' => $e->getMessage(),
                'user' => null,
                'code' => 500
            ]);
        }
    }

    public function update_user(Request $request)
    {
        try {
            $data = $request->except('username', 'firstname', 'lastname');
            $validation = [];
            if (isset($data['phonenumber'])) {
                $validation['phonenumber'] = 'required|string|unique:users';
            }
            if (isset($data['email'])) {
                $validation['email'] = 'required|email|unique:users';
            }
            if (isset($data))
                $validator = Validator::make($data, $validation);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'successMessage' => null,
                    'errorMessage' => $validator->getMessageBag(),
                    'user' => null,
                    'code' => Response::HTTP_BAD_REQUEST
                ]);
            }

            $user = User::where('username', $request->username)->firstOrFail();
            $userData = $request->except("username");
            $user->update($userData);
            return response()->json([
                'success' => true,
                'successMessage' => 'Success update user data',
                'errorMessage' => null,
                'user' => $user,
                'code' => 202
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'successMessage' => null,
                'errorMessage' => $e->getMessage(),
                'user' => null,
                'code' => 500
            ]);
        }
    }

    public function update_password(Request $request)
    {
        try {
            $data = $request->except('username');
            $validator = Validator::make($data, [
                'currentPassword' => 'required|string|min:6|max:50',
                'newPassword' => 'required|string|min:6|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'successMessage' => null,
                    'errorMessage' => $validator->getMessageBag(),
                    'code' => Response::HTTP_BAD_REQUEST
                ]);
            }

            $credentials = $request->only('username');
            $credentials['password'] = $data['currentPassword'];
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'successMessage' => null,
                    'errorMessage' => 'Incorrect password',
                    'code' => Response::HTTP_NOT_FOUND
                ]);
            }


            $user = User::where('username', $request->username)->firstOrFail();
            $user->update(['password' => bcrypt($data['newPassword'])]);
            return response()->json([
                'success' => true,
                'successMessage' => 'Success update password',
                'errorMessage' => null,
                'code' => 202
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'successMessage' => null,
                'errorMessage' => $e->getMessage(),
                'code' => 500
            ]);
        }
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
