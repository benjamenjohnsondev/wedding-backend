<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request): \Illuminate\Http\JsonResponse
    {
        // Shamelessly stolen for the most part from:
        // https://www.avyatech.com/rest-api-with-laravel-8-using-jwt-token/

        $credentials = $request->only('party_name', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'party_name' => 'required|string|min:3|max:50',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()->all()
            ], 409);
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
                'exception' => $e->getMessage()
            ], 500);
        }

        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        if (JWTAuth::authenticate()) {
            JWTAuth::invalidate($request->bearerToken());
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        }
        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->bearerToken());

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = JWTAuth::authenticate();
        return response()->json($user);
    }
}
